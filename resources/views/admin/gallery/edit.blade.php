@extends('admin.layouts.app')

@section('title', 'Gallery')

@section('content')
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm shadow-slate-100/50" 
         x-data="{ 
             previews: [], 
             filesList: [], 
             handleFiles(files) {
                 const newFiles = Array.from(files);
                 this.filesList = [...this.filesList, ...newFiles];
                 this.syncFiles();
             },
             removeFile(index) {
                 this.filesList.splice(index, 1);
                 this.syncFiles();
             },
             syncFiles() {
                 this.previews = this.filesList.map(file => ({
                     url: URL.createObjectURL(file),
                     name: file.name
                 }));
                 const dataTransfer = new DataTransfer();
                 this.filesList.forEach(file => dataTransfer.items.add(file));
                 this.$refs.fileInput.files = dataTransfer.files;
             }
         }">
        <div class="border-b border-slate-50 pb-5">
            <h2 class="text-xl font-extrabold text-slate-900">Gallery: {{ $vehicle->title }}</h2>
            <p class="text-xs text-slate-400 mt-1">Manage multiple photos and YouTube video references for this vehicle listing</p>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.vehicles.gallery.store', $vehicle) }}" class="mt-6 space-y-5 rounded-2xl border border-slate-100 bg-slate-50/50 p-5">
            @csrf
            <!-- Automatically detected inputs -->
            <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Upload Image(s)</label>
                    <input type="file" name="files[]" x-ref="fileInput" multiple @change="handleFiles($event.target.files)" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none">
                    <span class="text-[10px] text-slate-400">Multiple image selection supported</span>
                </div>
                
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wide">Or Add Video URL</label>
                    <input name="video_url" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-indigo-600" placeholder="e.g., https://youtube.com/watch?v=...">
                </div>
            </div>

            <!-- Previews with Remove Button -->
            <template x-if="previews.length > 0">
                <div class="space-y-3 border-t border-slate-100 pt-4">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Upload Previews (<span x-text="previews.length"></span>)</div>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                        <template x-for="(preview, index) in previews" :key="index">
                            <div class="group relative aspect-video overflow-hidden rounded-xl border border-slate-200 bg-white shadow-inner">
                                <img :src="preview.url" class="h-full w-full object-cover">
                                <button type="button" @click="removeFile(index)" class="absolute top-2 right-2 flex h-6 w-6 items-center justify-center rounded-full bg-red-600/90 text-xs font-bold text-white shadow hover:bg-red-700 transition-colors">
                                    ✕
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <div class="flex justify-end pt-2">
                <button class="rounded-xl bg-indigo-600 px-6 py-3 text-xs font-bold text-white shadow-lg shadow-indigo-600/10 transition-colors hover:bg-indigo-700">Upload to Gallery</button>
            </div>
        </form>

        <!-- Current Gallery Grid (Always 2 columns on mobile) -->
        <div class="mt-8">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-50 pb-3">Current Gallery Items</h3>
            <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($vehicle->gallery as $item)
                    <div class="group relative rounded-2xl border border-slate-100 bg-white p-3 shadow-sm transition-all duration-300 hover:shadow-md">
                        <div class="aspect-video overflow-hidden rounded-xl bg-slate-50">
                            @if ($item->type === 'image' && ! str_starts_with($item->file, 'http'))
                                <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('storage/'.$item->file) }}" alt="">
                            @else
                                <div class="flex h-full items-center justify-center text-xs font-bold text-slate-400 bg-slate-100">
                                    🎥 Video URL
                                </div>
                            @endif
                        </div>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">{{ $item->type }}</span>
                            <form method="POST" action="{{ route('admin.gallery.destroy', $item) }}" onsubmit="return confirm('Remove this from gallery?')">
                                @csrf 
                                @method('DELETE')
                                <button class="text-xs font-bold text-red-600 hover:underline">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
