<x-app-layout>
    <div class="max-w-6xl mx-auto py-6">
        <h2 class="text-3xl font-bold mb-6">Add Product</h2>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col gap-4">
                <div class="flex gap-4">
                    <div class="flex flex-col gap-2 w-full">
                        <label class="text-xl font-bold leading-6">Product Name:</label>
                        <input type="text" name="name" class="border-0 rounded-lg h-12" placeholder="Product Name...">
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <label class="text-xl font-bold leading-6">Product Price:</label>
                        <input type="number" name="price" class="border-0 rounded-lg h-12" placeholder="Product Price..." step="0.01">
                    </div>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <label class="text-xl font-bold leading-6">Product Description:</label>
                    <textarea name="description" class="border-0 rounded-lg" rows="4" cols="50" placeholder="Product Description..."></textarea>
                </div>
                <input type="hidden" name="image_path" id="image_path">
                <div>
                    <input type="file" name="image_file" id="image-file" value="" class="filepond">
{{--                    <input type="hidden" name="current_product_image" value="{{basename('651450d25fd49.png'??'')}}">--}}
                </div>
            </div>
                <div class="text-red-600">
                    <div class="form-group">
                        @if ($errors->any())
                            <div >
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 px-8 py-2 w-fit text-white rounded-2xl">Add</button>
            </div>
        </form>
    </div>

    @section('css_after')
        <link href="{{asset('assets/css/filepond.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/filepond-plugin-image-preview.css')}}" rel="stylesheet">
    @endsection
    @push('js_after_stack')
        <script src="{{asset('assets/js/filepond-polyfill.min.js')}}"></script>
        <script src="{{asset('assets/js/filepond-plugin-file-validate-size.js')}}"></script>
        <script src="{{asset('assets/js/filepond-plugin-file-validate-type.js')}}"></script>
        <script src="{{asset('assets/js/filepond-plugin-image-exif-orientation.js')}}"></script>
        <script src="{{asset('assets/js/filepond-plugin-image-preview.js')}}"></script>
        <script src="{{asset('assets/js/filepond.min.js')}}"></script>

        <script>
            $(document).ready(function() {
                FilePond.registerPlugin(FilePondPluginFileValidateSize);
                FilePond.registerPlugin(FilePondPluginFileValidateType);
                FilePond.registerPlugin(FilePondPluginImageExifOrientation);
                FilePond.registerPlugin(FilePondPluginImagePreview);
                FilePond.setOptions({
                    name: "image_file",
                    allowMultiple: false,
                    acceptedFileTypes: [
                        'image/png',
                        'image/jpeg',
                        'image/gif'
                    ],
                    fileValidateTypeLabelExpectedTypesMap: {
                        'image/jpeg': null,
                        'image/png': null,
                        'image/gif': null
                    },

                    maxFileSize: "8MB",
                    server: {
                        process: function(fieldName, file, metadata, load, error, progress, abort) {
                            // fieldName is the name of the input field
                            // file is the actual file object to send

                            const formData = new FormData();
                            formData.append('image_file', file, file.name);
                            const request = new XMLHttpRequest();
                            request.open('POST', '/api/image/process'); // here the product id will be

                            // Should call the progress method to update the progress to 100% before calling load
                            // Setting computable to false switches the loading indicator to infinite mode
                            request.upload.onprogress = function(e) {
                                progress(e.lengthComputable, e.loaded, e.total);

                            };
                            // Should call the load method when done and pass the returned server file id
                            // this server file id is then used later on when reverting or restoring a file
                            // so your server knows which file to return without exposing that info to the client
                            request.onload = function(scope) {
                                if (request.status >= 200 && request.status < 300) {
                                    // the load method accepts either a string (id) or an object
                                    load(JSON.parse(request.responseText));
                                    console.log("ok");
                                } else {
                                    // Can call the error method if something is wrong, should exit after
                                    error('Failed to upload image.');
                                }
                            };
                            request.send(formData);
                            // Should expose an abort method so the request can be cancelled
                            return {
                                abort: function() {
                                    // This function is entered if the user has tapped the cancel button
                                    request.abort();
                                    // Let FilePond know the request has been cancelled
                                    abort();
                                }
                            };

                        },
                        load: '/api/product/images/',
                        revert: '/api/image/process/',
                        restore: '/api/product/images/',
                    }
                });
                $('input[type="file"]').each(function() {
                    var tempImageId = $(this).nextAll("input[name='temp_value[]']:first").val();
                    var imageId = $(this).next("input[type='hidden']").val();
                    var filePond;
                    if (tempImageId) {
                        filePond = FilePond.create(this, {
                            files: [{
                                source: tempImageId,
                                options: {
                                    type: 'limbo'
                                }
                            }],
                        });
                    } else if (imageId) {
                        filePond = FilePond.create(this, {
                            files: [{
                                source: imageId,
                                options: {
                                    type: 'local'
                                }
                            }],
                        });
                    } else {
                        filePond = FilePond.create(this);
                    }
                    var parent = filePond;
                    filePond.onprocessfile = function(error, file) {
                        if (!error) {

                            $(parent.element).nextAll("input[name='temp_value[]']:first").val(file.serverId);
                        }
                        console.log("double ok");
                        document.getElementById("image_path").value = file.serverId;
                        // document.getElementById("temp_value").value = file.serverId;
                    };
                    // filePond.onremovefile = function(error, file){
                    //     console.log("chala k nai"+ file.serverId);
                    //     filePond.removeFile(file.serverId);
                    // };
                    filePond.onprocessfilerevert = function(file) {
                        $(parent.element).nextAll("input[name='temp_value[]']:first").val(null);
                        console.log('test this');
                    }
                });
            })
        </script>
    @endpush
</x-app-layout>
