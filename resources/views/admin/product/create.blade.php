<x-app-layout>
    <section class="wsus__product mt_145 pb_100">
        <div class="container">

            <h4 class="text-primary pt-3 pb-3">Dashboard</h4>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Create Products</h5>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Go Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image" class="mt-2 mb-2">Image</label>
                            <x-text-input type="file" class="form-control" name="image" id="image" />
                        </div>
                        <div class="form-group">
                            <label for="images" class="mt-2 mb-2">Images</label>
                            <x-text-input type="file" class="form-control" name="images[]" id="images" multiple />
                        </div>

                        <div id="imageModal" class="modal"
                            style="display: none; position: fixed; top: 10%; left: 30%; z-index: 1050; background: white; width: 60%; height: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
                            <button type="button" id="closeModal" style="float: right;">&times;</button>
                            <h4>Selected Image Preview</h4>
                            <div id="modal-content" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="mt-2 mb-2">Name</label>
                            <x-text-input type="text" class="form-control" name="name" id="name" />
                        </div>
                        <div class="form-group">
                            <label for="price" class="mt-2 mb-2">Price</label>
                            <x-text-input type="text" class="form-control" name="price" id="price" />
                        </div>
                        <div class="form-group">
                            <label for="colors" class="mt-2 mb-2">Colors</label>
                            <select name="colors[]" id="colors" class="form-control" multiple>
                                <option>---Select Color---</option>
                                <option value="red">Red</option>
                                <option value="blue">Blue</option>
                                <option value="green">Green</option>
                                <option value="yellow">Yellow</option>
                                <option value="orange">Orange</option>
                                <option value="purple">Purple</option>
                                <option value="pink">Pink</option>
                                <option value="brown">Brown</option>
                                <option value="gray">Gray</option>
                                <option value="black">Black</option>
                                <option value="white">White</option>
                                <option value="navy">Navy</option>
                                <option value="maroon">Maroon</option>
                                <option value="olive">Olive</option>
                                <option value="lime">Lime</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="s_desc" class="mt-2 mb-2">Short Description</label>
                            <x-text-input type="text" class="form-control" name="short_description" id="s_desc" />
                        </div>
                        <div class="form-group">
                            <label for="qty" class="mt-2 mb-2">Qty</label>
                            <x-text-input type="text" class="form-control" name="qty" id="qty" />
                        </div>
                        <div class="form-group">
                            <label for="sku" class="mt-2 mb-2">Sku</label>
                            <x-text-input type="text" class="form-control" name="sku" id="sku" />
                        </div>
                        <div class="form-group">
                            <label for="description" class="mt-2 mb-2">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10"></textarea>
                        </div>

                        <x-primary-button>Submit</x-primary-button>
                    </form>
                </div>
            </div>

        </div>
    </section>

    <x-slot name="script">

        <script>
            $(document).ready(function() {
                // Initialize Select2 on the colors field
                $('#colors').select2({
                    placeholder: "Select Colors",
                    allowClear: true
                });

                const $singleImageInput = $("#image");
                const $multipleImageInput = $("#images");
                const $modal = $("#imageModal");
                const $modalContent = $("#modal-content");
                const $closeModal = $("#closeModal");

                // Function to display images in the modal
                function previewImages(files) {
                    $modalContent.html(""); // Clear previous content
                    $.each(files, function(index, file) {
                        if (file.type.startsWith("image/")) {
                            const img = $("<img>").attr("src", URL.createObjectURL(file));
                            img.css({
                                maxWidth: "100px",
                                maxHeight: "100px",
                                objectFit: "cover",
                                border: "1px solid #ddd",
                                borderRadius: "5px",
                                margin: "5px"
                            });
                            $modalContent.append(img);
                        }
                    });
                    $modal.show(); // Show the modal
                }

                // Event listener for single image input
                $singleImageInput.on("change", function() {
                    if (this.files.length > 0) {
                        previewImages(this.files);
                    }
                });

                // Event listener for multiple image input
                $multipleImageInput.on("change", function() {
                    if (this.files.length > 0) {
                        previewImages(this.files);
                    }
                });

                // Close modal
                $closeModal.on("click", function() {
                    $modal.hide();
                });

                // Initialize TinyMCE
                tinymce.init({
                    selector: 'textarea#description',
                    height: 500,
                    plugins: [
                        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                        'insertdatetime', 'media', 'table', 'help', 'wordcount'
                    ],
                    toolbar: 'undo redo | blocks | ' +
                        'bold italic backcolor | alignleft aligncenter ' +
                        'alignright alignjustify | bullist numlist outdent indent | ' +
                        'removeformat | help',
                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
                });
                // 
                $('form').on('submit', function(e) {
                    let errors = [];
                    const requiredFields = ['image', 'name', 'price', 'colors', 'short_description',
                        'qty',
                    ];

                    requiredFields.forEach(function(field) {
                        const input = $(`[name="${field}"]`);
                        if (input.length && !input.val().trim()) {
                            errors.push(`${field.replace('_', ' ')} is required.`);
                        }
                    });

                    if (errors.length > 0) {
                        e.preventDefault();
                        errors.forEach(function(error) {
                            toastr.error(error);
                        });
                    }
                });
            });
        </script>
    </x-slot>

</x-app-layout>
