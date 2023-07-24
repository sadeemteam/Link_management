<?php
    $user = auth()->user();
    $SA = $user->hasRole('SUPER-ADMIN');
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <ul class="nav nav-pills" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button 
                role="tab" 
                type="button" 
                id="pills-home-tab" 
                data-bs-toggle="pill" 
                class="nav-link {{session('settings') ? 'active' : '';}}" 
                data-bs-target="#pills-home" 
                aria-controls="pills-home" 
                aria-selected="true"
                onclick="tabActiveController('{{session('settings')}}', 'settings')"
            >
                {{__('Settings')}}
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button 
                role="tab" 
                type="button" 
                class="nav-link {{session('blocks') ? 'active' : '';}}" 
                d="pills-profile-tab" 
                data-bs-toggle="pill" 
                data-bs-target="#pills-profile" 
                aria-controls="pills-profile" 
                aria-selected="false"
                onclick="tabActiveController('{{session('blocks')}}', 'blocks')"
            >
                {{__('Blocks')}}
            </button>
        </li>
    </ul>

    <button 
        class="btn btn-primary text-white"
        data-bs-toggle="modal" 
        data-bs-target="#addLinkItemsModal"
    >
        <i class="fa-solid fa-plus"></i>
        {{__('Add Block')}}
    </button>
    @include('components.link_items.AddLinkItem')
</div>

<div class="tab-content" id="pills-tabContent">
    <div 
        id="pills-home" 
        role="tabpanel" 
        class="tab-pane fade {{session('settings') ? 'show active' : '';}}" 
        aria-labelledby="pills-home-tab"
    >
        @include('components.link_items.LinkProfile')
        @include('components.link_items.LinkSocials')
        @include('components.link_items.LinkThems')
        
        @if($SA || $user->pricing_plan->name != "BASIC")
            @include('components.link_items.LinkCustomTheme')
        @endif

    </div>
    <div 
        role="tabpanel" 
        id="pills-profile" 
        class="tab-pane fade {{session('blocks') ? 'show active' : '';}}" 
        aria-labelledby="pills-profile-tab"
    >
        @include('components.link_items.LinkItems')
    </div>
</div>