@props(['model'])

<div>
    <section class="container w-full items-center">
        <div class="w-full bg-white rounded-lg overflow-hidden items-center">
            <div class="px-0 py-1">
                <div id="image-preview" class="p-2 w-full h-full border border-gray-300 rounded-lg items-center text-center cursor-pointer">
                    <input id="upload" wire:model={{ $model }} type="file" class="hidden" accept="image/*" />
                    @if($this->photo)
                        <label for="upload" class="cursor-pointer">
                            <img src="{{ $this->photo->temporaryUrl() }}" class="max-h-96 rounded-lg mx-auto" alt="Image preview" />
                        </label>
                    @else
                        <label for="upload" class="cursor-pointer m-8 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-700 mx-auto mb-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-700">Upload picture</h5>
                            <p class="font-normal text-sm text-gray-400 md:px-6">Choose photo size should be less than <b class="text-gray-600">2mb</b></p>
                            <p class="font-normal text-sm text-gray-400 md:px-6">and should be in <b class="text-gray-600">JPG or PNG</b> format.</p>
                            <span id="filename" class="text-gray-500 bg-gray-200 z-50"></span>
                        </label>
                    @endif
                </div>
                {{-- <div class="flex items-center justify-center">
                    <div class="w-full">
                        <label class="w-full text-white bg-[#050708] hover:bg-[#050708]/90 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center justify-center mr-2 mb-2 cursor-pointer">
                        <span class="text-center ml-2">Upload</span>
                        </label>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
    {{-- <script>
        const uploadInput = document.getElementById('upload');
        const filenameLabel = document.getElementById('filename');
        const imagePreview = document.getElementById('image-preview');
    
        // Check if the event listener has been added before
        let isEventListenerAdded = false;
    
        uploadInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
    
            if (file) {
            filenameLabel.textContent = file.name;
    
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.innerHTML =
                `<img src="${e.target.result}" class="max-h-96 rounded-lg mx-auto" alt="Image preview" />`;
                imagePreview.classList.remove('border-dashed', 'border-2', 'border-gray-400');
    
                // Add event listener for image preview only once
                if (!isEventListenerAdded) {
                imagePreview.addEventListener('click', () => {
                    uploadInput.click();
                });
    
                isEventListenerAdded = true;
                }
            };
            reader.readAsDataURL(file);
            } else {
            filenameLabel.textContent = '';
            imagePreview.innerHTML =
                `<div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center text-gray-500">No image preview</div>`;
            imagePreview.classList.add('border-dashed', 'border-2', 'border-gray-400');
    
            // Remove the event listener when there's no image
            imagePreview.removeEventListener('click', () => {
                uploadInput.click();
            });
    
            isEventListenerAdded = false;
            }
        });
    
        uploadInput.addEventListener('click', (event) => {
            event.stopPropagation();
        });
    </script> --}}
</div>