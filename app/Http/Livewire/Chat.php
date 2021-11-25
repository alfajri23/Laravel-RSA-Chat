<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use ParagonIE\EasyRSA\KeyPair;
use ParagonIE\EasyRSA\EasyRSA;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
//use Request;
use Image;

class Chat extends Component
{
    use WithFileUploads;

	public $id_receiver;
	public $publickey_receiver;
	public $privatekey,$publickey;
    public $pesan_kirim;
    public $nama_chat;
    public $image;

	public function mount($id)
    {
    	$this->id_receiver = $id;
    	$receiver = User::where('id',$id)->get();
    	$this->publickey_receiver = $receiver[0]["public_key"];
        $this->nama_chat = $receiver[0]["name"];

        $this->publickey = auth()->user()->public_key;
        $this->privatekey = auth()->user()->private_key;

        //dd($this->publickey_receiver);

    }

    public function render()
    {
    	//dd($this->id_receiver);
    	$chats = Message::where('id_penerima',$this->id_receiver)
                ->orWhere('id_penerima',auth()->user()->id)
                ->orWhere('id_pengirim',$this->id_receiver)
    			->orWhere('id_pengirim',auth()->user()->id)
    			->get();

        //dd($chats);

        //buat variabel untuk ditampilkan
        $pesans = [];
        $gambar = '';
        foreach ($chats as $chat) {
            $pesan = '';
            $gambar = '';

            if(isset($chat["image"])){
                $gambar = $chat["image"];
            }else{
                if($chat['id_pengirim'] == auth()->user()->id){
                    $pesan = $this->deskripsi($this->privatekey,$chat['pesan_saya']);
                }
                elseif ($chat['id_penerima'] == auth()->user()->id) {
                    $pesan = $this->deskripsi($this->privatekey,$chat['pesan']);
                }
            }

            


            $pesans[] = array(
                'id' => $chat['id'],
                'pesan' => $pesan,
                'gambar' => $gambar,
                'id_pengirim' => $chat['id_pengirim'],
                'id_penerima' =>  $chat['id_penerima'],
                'created_at' =>  $chat['created_at'],
            );
        }

        //dd($pesans);

    	
        return view('livewire.chat',["chats" => $pesans]);
    }

    public function store(){
        //dd("hallos");
        $publicMessage = $this->enskripsi($this->publickey_receiver,$this->pesan_kirim);
        $privateMessage = $this->enskripsi($this->publickey,$this->pesan_kirim);

        Message::create([
            'id_pengirim' => auth()->user()->id,
            'id_penerima' => $this->id_receiver,
            'pesan' => $publicMessage,
            'pesan_saya' => $privateMessage,
        ]);

        $this->pesan_kirim='';
    }

    public function store_image(Request $request){

        // dd("hallo");

        $id_penerimas =  $request->id_penerima;
        //dd($id_penerimas);

        if( $request->hasFile( 'image' ) ) {
            $image = $request->file( 'image' );
            //dd($image);
            $imageType = $image->getClientOriginalExtension();
            $imageStr = (string) Image::make( $image )->
                                     resize( 300, null, function ( $constraint ) {
                                         $constraint->aspectRatio();
                                     })->encode( $imageType );

            $image = base64_encode( $imageStr );
            $imageType = $imageType;
            $fullImage = 'data:image/'.$imageType.';base64,'.$image;

            Message::create([
                'id_pengirim' => auth()->user()->id,
                'id_penerima' => $id_penerimas,
                'image' => $fullImage,
            ]);
        }

        return redirect()->route('main-chat', ['id' => $id_penerimas]);
    }

    public function enskripsi($key,$pesan){
        $keys = unserialize($key);
        $pesan = EasyRSA::encrypt($pesan, $keys);
        return $pesan;
    }

    public function deskripsi($key,$pesan){
        $keys = unserialize($key);
        $pesan = EasyRSA::decrypt($pesan, $keys);
        return $pesan;
    }
}
