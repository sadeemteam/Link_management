<?php
$features = [['name' => 'Bio Links', 'icon' => 'fa-regular fa-heart-circle-check'], ['name' => 'Free Features', 'icon' => 'fa-regular fa-heart-circle-check'], ['name' => '19+ Themes', 'icon' => 'fa-solid fa-fill-drip'], ['name' => 'Visitor Status Tracking', 'icon' => 'fa-solid fa-chart-line-up'], ['name' => 'Full Customizing Option', 'icon' => 'fa-regular fa-calendar-lines-pen']];

$sections = [];
foreach ($appSections as $item) {
    if ($item['name'] == 'Features') {
        $sections = $item;
        break;
    }
}
?>
<div class="container pb-5 pt-3 features mt-4" style="margin-top: 40px">
    <h1 class="fw-bold text-center mb-3" style="font-size: 36px;">
        {{__('Features')}}
    </h1>

    <div class="@if ($SA) home-section-edit @endif">
        @if ($SA)
            <i style="font-size: 18px;" class="fa-solid fa-pen editIcon" data-bs-toggle="modal"
                data-bs-target="#editSectionList{{ $sections->id }}"></i>
        @endif

        <div class="row align-items-center">
            @foreach (json_decode($sections->section_list) as $list)
                <?php
                    $encode = json_encode($list);
                    $item = json_decode($encode, true);
                ?>
                <div class="col-6 col-lg-3 my-2">
                    <div class="card border-0 text-center">
                        <i class="{{ $item['icon'] }}"></i>
                        <p>{{ $item['content'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('components.home-edit.EditSectionList')
</div>
