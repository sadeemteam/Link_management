<?php
$sections = [];
foreach ($appSections as $item) {
    if ($item['name'] == 'Header') {
        $sections = $item;
        break;
    }
}
?>

<div class="home-header">
    <div class="container pt-4 @if ($SA) home-section-edit @endif">
        @if ($SA)
            <i style="font-size: 30px;" class="fa-solid fa-pen editIcon" data-bs-toggle="modal"
                data-bs-target="#editSection{{ $sections->id }}"></i>
        @endif
        <div style="max-width: 760px; width: 100%; margin: auto">
            <div class="">
                <h1 class="fw-bold slogan-text" style="position: relative;">
                    {{ $sections->title }}
                </h1>

                @if ($user)
                    <a href="/dashboard/links" class="input-group-text btn btn-lg btn-primary text-white px-4">
                        {{__('Get Another Link')}}
                    </a>
                @else
                    <div class="input-group mx-auto linkCreateInput">
                        <span class="input-group-text linkPrefix border-0">
                            /
                        </span>
                        <input required id="linkname" name="linkname" placeholder="yourname or linkname"
                            class="form-control px-2 border-0">
                        <button id="submitLinkname" class="btn btn-primary text-white">
                            {{__('Get Your Link')}}
                        </button>
                    </div>
                @endif

                <script>
                    document
                        .getElementById("submitLinkname")
                        ?.addEventListener("click", function(e) {
                            let value = document.getElementById("linkname").value;
                            window.open(`/register?linkname=${value.toLowerCase()}`, '_blank');
                        });
                </script>
            </div>

            <div class="my-4 @if ($SA) home-section-edit @endif">
                <div class="row">
                    @foreach (json_decode($sections->section_list) as $list)
                        <?php
                        $encode = json_encode($list);
                        $item = json_decode($encode, true);
                        ?>
                        <div class="col-6 col-lg-3 text-lg-center ps-3 pe-3 pt-3">
                            <p class="ps-4 ps-lg-0">
                                <i style="color: #2e90fa" class="{{ $item['icon'] }}"></i>
                                {{ $item['content'] }}
                            </p>
                        </div>
                    @endforeach
                </div>

                @if ($SA)
                    <i style="font-size: 18px;" class="fa-solid fa-pen editIcon" data-bs-toggle="modal"
                        data-bs-target="#editSectionList{{ $sections->id }}"></i>
                @endif
            </div>
        </div>

        <div>
            <img width="100%" src="{{ asset($sections->thumbnail) }}" alt="">
        </div>
    </div>

    @include('components.home-edit.EditSection')
    @include('components.home-edit.EditSectionList')
</div>
