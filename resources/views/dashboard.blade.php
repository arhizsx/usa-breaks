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
  min-height: 80% !important;
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
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <label for="items" class="form-label">Items</label>
                                    <input type="number" disabled class="form-control mb-3" name="items" id="items" value="0">
                                </div>
                                <div class="flex-fill">
                                    <label for="credits" class="form-label">Credits</label>
                                    <input type="text" disabled class="form-control mb-3" name="credits" id="credits" value="UNLIMITED">
                                </div>
                                <div class="flex-fill">
                                    <label for="priority" class="form-label">Priority</label>
                                    <input type="text" disabled class="form-control mb-3" name="priority" id="priority" value="VIP">
                                </div>
                            </div>
                            <label for="filename" class="form-label">Filename</label>
                            <input type="text" class="form-control mb-3" name="filename" id="filename">
                            <button disabled id="scrape_btn" class="btn btn-lg w-100 bg-primary text-white mb-3">Get Info</button>
                        </div>

                        <div class="col-xl-6 mb-3">
                            <label for="certificate_numbers" class="form-label">Certificate Numbers</label>
                            <textarea class="form-control mb-3" name="certificate_numbers" id="certificate_numbers"></textarea>
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

$(document).on("keyup", "#certificate_numbers", function(){

    var certs= $(this).val().split(/\r?\n/);


    if( certs.length > 0 ){
        $(document).find("[name='items']").val( certs.length );
        $(document).find("#scrape_btn").prop("disabled", false);
    } else {
        $(document).find("[name='items']").val(0);
        $(document).find("#scrape_btn").prop("disabled", true);
    }

});

</script>
