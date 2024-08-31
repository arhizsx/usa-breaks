<style>
textarea {
  /* margin:0px 0px; this is redundant anyways since its specified below*/
  padding-top:10px;
  padding-bottom:25px; /* increased! */
  /* height:16px; */
  /* line-height:16px; */
  width:100%; /* changed from 96 to 100% */
  display:block;
  /* margin:0px auto; not needed since i have width 100% now */
  font-size: 2em !important;
}
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container-fluid p-4">
                    <div class="row mb-3">
                        <div class="col-8">
                            <label for="filename" class="form-label">Filename</label>
                            <input type="text" class="form-control" name="filename" id="filename">
                        </div>
                        <div class="col-4 align-items-end d-flex ">
                            <button class="btn btn-lg w-100 bg-primary text-white">Scrape</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="certificate_numbers" class="form-label">Certificate Numbers</label>
                            <textarea class="form-control" name="certificate_numbers" id="certificate_numbers"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
<script>

function expandTextarea(id) {
    document.getElementById(id).addEventListener('keyup', function() {
        this.style.overflow = 'hidden';
        this.style.height = 0;
        this.style.height = this.scrollHeight + 'px';
    }, false);
}

expandTextarea('certificate_numbers');

</script>
