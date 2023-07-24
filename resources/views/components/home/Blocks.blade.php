<?php
$sections = [];
foreach ($appSections as $item) {
    if ($item['name'] == 'Add Blocks') {
        $sections = $item;
        break;
    }
}
?>
<div class="container create-block py-5">
    <div class="@if ($SA) home-section-edit @endif">
        @if ($SA)
            <i data-bs-toggle="modal" data-bs-target="#editSection{{ $sections->id }}" class="fa-solid fa-pen editIcon"
                style="font-size: 30px;"></i>
        @endif

        <div class="row align-items-center">
            <div class="col-lg-6 pb-2 ps-lg-4" data-aos-duration="1000" data-aos="zoom-in">
                <h1 class="fw-bold" style="font-size: 36px;">
                    {{ $sections->title }}
                </h1>
                <p class="pt-4 pb-3">
                    {{ $sections->description }}
                </p>

                <div class="@if ($SA) home-section-edit @endif">
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

                <a href="/dashboard/links" class="btn btn-light px-4 py-2">{{__('Add Block')}}</a>
            </div>

            <div class="col-lg-6" data-aos-duration="1000" data-aos="zoom-in">
                <img class="w-100 h-100 pt-5 pt-lg-0" src="{{ asset($sections->thumbnail) }}" alt="">
            </div>
        </div>

        @include('components.home-edit.EditSection')
        @include('components.home-edit.EditSectionList')
    </div>
</div>
