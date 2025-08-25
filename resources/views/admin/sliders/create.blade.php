@extends('admin.layouts.app')
@section('title', 'Slider Create')
@push('styles')
    <style>
        .handle {
            cursor: grab;
            color: #666;
        }

        .handle:active {
            cursor: grabbing;
        }
    </style>
@endpush
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    {{-- <div class="page-pretitle">
                        Overview
                    </div> --}}
                    <h2 class="page-title">
                        Slider
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('admin.sliders.store') }}" method="post">
                @csrf
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <h3 class="card-title">Create new slider</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Slider Name</label>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            placeholder="Slider Name" name="title" value="{{ old('title') }}">
                                        <small class="form-hint">
                                            @error('title')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Type</label>
                                    <div class="col">
                                        <select class="form-control" name="type">
                                            @foreach (sliderTypes() as $type)
                                                <option value="{{ $type }}">
                                                    {{ str_replace('_', ' ', ucwords($type)) }}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-hint">
                                            @error('type')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Status</label>
                                    <div class="col">
                                        <select class="form-control" name="status">
                                            <option value="0" @selected(old('status') == 'active')>Active</option>
                                            <option value="1" @selected(old('status') == 'inactive')>Inactive</option>
                                        </select>
                                        <small class="form-hint">
                                            @error('status')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Slider Images</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-md">
                                        <thead>
                                            <tr>
                                                <th><i class="fas fa-arrows"></i></th>
                                                <th>Preview</th>
                                                <th>Title</th>
                                                <th>Desc</th>
                                                <th>Link</th>
                                                <th>Upload File</th>
                                                <th>-</th>
                                            </tr>
                                        </thead>
                                        <tbody id="slider-container">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group mt-4">
                                    <button class="btn btn-success" id="add_slider" type="button">Add slider</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modals">

    </div>
    <template id="media-template">
        @include('admin.components.media.popup', [
            'modalId' => 'slider-modal-__INDEX__',
            'inputType' => 'single',
            'imageInputName' => 'slider_info[__INDEX__][image]',
        ])
    </template>
    <div id="media-container"></div>
@endsection


@push('scripts')

 <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.6/Sortable.min.js" integrity="sha512-csIng5zcB+XpulRUa+ev1zKo7zRNGpEaVfNB9On1no9KYTEY/rLGAEEpvgdw6nim1WdTuihZY1eqZ31K7/fZjw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

 <script>
    function setSlidePosition() {
        document.querySelectorAll('.slider-item').forEach((el, index) => {
            el.querySelector('.position').value = index;
        });
    }

    function attrHtml(index) {
        return `
            <tr class="slider-item">
                <td>
                    <span class="handle"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-menu-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l16 0" /></svg></span>
                    <input type="hidden" name="slider_info[${index}][position]" class="position">
                </td>
                <td><div id="slider-modal-${index}-wrapper"></div></td>
                <td><input type="text" class="form-control" name="slider_info[${index}][text]" placeholder="Enter title"></td>
                <td><input type="text" class="form-control" name="slider_info[${index}][description]" placeholder="Enter title"></td>
                <td><input class="form-control" name="slider_info[${index}][link]"></td>
                <td>
                     <button type="button" class="btn btn-primary" id="slider-modal-${index}-btn"
                        data-bs-toggle="offcanvas" data-bs-target="#slider-modal-${index}"
                        aria-controls="slider-modal-${index}" aria-expanded="false">
                        Upload File
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger w-100 remove_slider" data-index="${index}" type="button">
                        Remove
                    </button>
                </td>
            </tr>
        `;
    }

    document.addEventListener("DOMContentLoaded", function () {
        let i = 0;

        // Add new slider row
        document.getElementById("add_slider").addEventListener("click", function () {
            const html = attrHtml(i);

            // Append row
            document.getElementById("slider-container").insertAdjacentHTML("beforeend", html);

            const mediaContainer = document.getElementById('media-container');
            const existingMedia = mediaContainer.querySelector(`#slider-modal-${i}`);
            if (!existingMedia) {
                const template = document.getElementById('media-template').innerHTML;
                const rendered = template.replace(/__INDEX__/g, i);
                mediaContainer.insertAdjacentHTML('beforeend', rendered);

                const newModal = document.getElementById(`slider-modal-${i}`);
                if (newModal) {
                    const offcanvas = new tabler.Offcanvas(newModal);
                    newModal.addEventListener('shown.bs.offcanvas', function() {
                        const container = newModal.querySelector(`#ajax-container-${newModal.id}`);
                        const route = newModal.getAttribute('data-route');
                        if (container && route) {
                            loadData(`${route}`, container);
                        } else {
                            console.error('Missing required elements or data for modal:', newModal.id, {
                                container,
                                route,
                                folderId
                            });
                        }
                    });
                }
            }

            setSlidePosition();
            i++;
        });

        // Remove slider row
        document.addEventListener("click", function (e) {
            if (e.target.closest(".remove_slider")) {
                const btn = e.target.closest(".remove_slider");
                const index = btn.dataset.index;

                const modal = document.getElementById(`slider-modal${index}`);
                if (modal) modal.remove();

                btn.closest(".slider-item").remove();
                setSlidePosition();
            }
        });

        // Enable SortableJS
        new Sortable(document.getElementById("slider-container"), {
            handle: ".handle", // drag handle
            animation: 150,
            onEnd: function () {
                setSlidePosition();
            }
        });
    });
</script>
@endpush