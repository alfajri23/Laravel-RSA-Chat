



<div id="main">

	<style type="text/css">
	nav{
		display: none !important;
	}
	</style>
	<div class="container px-2 mt-3" style="height: 100%">
		<div class="container d-flex justify-content-center bg-success py-2">
			<h5 class="my-0 font-weight-bold text-white">{{$nama_chat}}</h5>
		</div>
		<section class="chat-body p-3 bg-white d-flex flex-column justify-content-end">
			<section class="chat-message" wire:poll.1000ms>
				@foreach($chats as $chat)
				<div class="clearfix my-2">
					

					@if($chat["id_pengirim"] == auth()->user()->id)
						<div class="chat-text-send font-weight-bold">
					@else
						<div class="chat-text-receiver font-weight-bold">
					@endif

					@isset($chat["gambar"])
						<img src="{{ $chat["gambar"] }}">
					@endisset
					
					{{$chat["pesan"]}}
					</div>
				</div>
				@endforeach
				
				
			</section>

			
			<section class="chat-action d-flex flex-row align-items-center">
				<input class="form-control form-control-md" type="text" placeholder="pesan" wire:model.defer="pesan_kirim">
				<button type="button" class="btn" data-toggle="modal" data-target="#exampleModal">
				  <i class="fa fa-file-image-o" aria-hidden="true"></i>
				</button>
				<button wire:click="store()" class="btn btn-success">Send
				</button>
				
			</section>
			
			
		</section>
	    
	</div>

	<!-- Modal -->
	<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Upload Gambar</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form class="form-horizontal" action="{{ route('store_image') }}" method="POST" enctype="multipart/form-data">
	        	@csrf
	        	<input type="hidden" name="id_penerima" value="{{$id_receiver}}">
	        	<!-- <div class="custom-file">
				  <input type="file" name="image" class="custom-file-input" id="customFile">
				  <label class="custom-file-label" for="customFile">Pilih gambar mu</label>
				</div>   -->
				<input type="file" id="avatar" name="image" accept="image/png, image/jpeg">


	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Kirim</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>

</div>

