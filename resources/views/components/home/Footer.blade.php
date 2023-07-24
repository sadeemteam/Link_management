<?php
function getSection($appSections, $name)
{
    foreach ($appSections as $item) {
        if ($item['name'] == $name) {
            return $item;
        }
    }
    return [];
}
?>
<section class="footer">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-5 text-center text-lg-start">
                <div>
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
                        <img 
                            alt=""
                            width="48px" 
                            height="48px" 
                            class="rounded-3" 
                            src="{{ asset($app->logo) }}" 
                        >
                        <h4 class="ms-3 fw-bold">
                            {{$app->title}}
                        </h4>
                    </div>
                    <p class="py-3 text-disable">
                        {{$app->description}}
                    </p>
                </div>

                <div>
                    <?php
                        $sections = getSection($appSections, 'Follow On');
                    ?>
                    <h6 class="fw-bold py-2">{{ $sections->title }}</h6>
                    <div class="@if ($SA) home-section-edit @endif">
                        @if ($SA)
                            <i style="font-size: 18px;" class="fa-solid fa-pen editIcon" data-bs-toggle="modal"
                                data-bs-target="#editSectionList{{ $sections->id }}"></i>
                        @endif
                        <div class="styled-icon justify-content-center justify-content-lg-start">
                            @foreach (json_decode($sections->section_list) as $list)
                                <?php
                                    $encode = json_encode($list);
                                    $item = json_decode($encode, true);
                                ?>
                                <a target="_blank" href="{{ $item['url'] }}">
                                    <i class="{{ $item['icon'] }}"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    @include('components.home-edit.EditSectionList')
                </div>
            </div>
            <div class="col-lg-1"></div>

            <div class="col-lg-2 text-center text-lg-start">
                <div>
                    <?php
                        $sections = getSection($appSections, 'Support');
                    ?>
                    <h6 class="fw-bold pb-3 pt-4">{{ $sections->title }}</h6>
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
                                    <a class="text-disable text-decoration-none" href="{{ $item['url'] }}">
                                        {{ $item['content'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @include('components.home-edit.EditSectionList')
                </div>
            </div>

            <div class="col-lg-4 text-center text-lg-start">
                <div>
                    <?php
                        $sections = getSection($appSections, 'Address');
                    ?>
                    <h6 class="fw-bold pb-3 pt-4">{{ $sections->title }}</h6>
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
                                <li class="text-disable">{{ $item['content'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @include('components.home-edit.EditSectionList')
                </div>
            </div>
        </div>
    </div>

    <div class="border-top"></div>

    <div class="container py-4 px-2 text-center">
        <p>{{$app->copyright}}</p>
    </div>
</section>
