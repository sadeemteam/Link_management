<?php
$sections = [];
foreach ($appSections as $item) {
    if ($item['name'] == 'Create Link') {
        $sections = $item;
        break;
    }
}
?>

<div class="container py-5 create-link">
    <div class="@if ($SA) home-section-edit @endif">
        @if ($SA)
            <i style="font-size: 30px;" class="fa-solid fa-pen editIcon" data-bs-toggle="modal"
                data-bs-target="#editSection{{ $sections->id }}"></i>
        @endif

        <div class="row align-items-center">
            <div class="col-lg-6" data-aos-duration="1000" data-aos="fade-right">
                <img class="w-100 h-100 pb-5 pb-lg-0" src="{{ asset($sections->thumbnail) }}" alt="">
            </div>
            <div class="col-lg-6 pb-2" data-aos-duration="1000" data-aos="fade-left">
                <h1 class="fw-bold" style="font-size: 36px;">
                    {{ $sections->title }}
                </h1>
                <p class="pt-4 pb-3">
                    {{ $sections->description }}
                </p>

                {{-- {{ var_dump(json_decode($sections->section_list)) }} --}}
                <div class="me-0 me-lg-3 @if ($SA) home-section-edit @endif">
                    @if ($SA)
                        <i style="font-size: 18px;" class="fa-solid fa-pen editIcon" data-bs-toggle="modal"
                            data-bs-target="#editSectionList{{ $sections->id }}"></i>
                    @endif

                    <ul class="list-unstyled styled-list">
                        @foreach (json_decode($sections->section_list) as $list)
                            <?php
                            $encode = json_encode($list);
                            $item = json_decode($encode, true);
                            ?>
                            <li>
                                <span>
                                    <i class="{{ $item['icon'] }} text-primary"></i>
                                    <i class="{{ $item['icon'] }} text-primary" style="margin-left: -12px"></i>
                                </span>
                                {{ $item['content'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <a href="/dashboard/links" class="btn btn-light px-4 py-2">
                    {{__('Create Link')}}
                </a>
            </div>
        </div>
        @include('components.home-edit.EditSection')
        @include('components.home-edit.EditSectionList')
    </div>
</div>
