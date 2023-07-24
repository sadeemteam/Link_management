<div 
    id="bioLinkItems" 
    class="bioLinkItems" 
    data-id="{{$link->id}}" 
    
>
    @foreach($link->items as $item)
        @if($item->item_type != "Socials")
            <section class="draggable" draggable="true">
                <i 
                    id="elementMove"
                    style="font-size: 18px; color: #667085" 
                    class="fa-solid fa-arrows-up-down-left-right" 
                ></i>
                <div 
                    data-item_id="{{$item->id}}" 
                    class="card border-0 shadow-sm w-100 py-3 px-3"
                >
                    <div class="d-flex align-items-center justify-content-between">
                        <i class="{{$item->item_icon}} me-3" style="font-size: 14px; color: #667085"></i>
                        <h6 class="m-0 text-center">{{$item->item_title}}</h6>

                        <div class="dropdown">
                            <button 
                                class="btn py-0 px-3" 
                                style="font-size: 18px;"
                                data-bs-toggle="dropdown" 
                            >
                                <i class="fa-solid fa-ellipsis-vertical" style="color: #667085" ></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button 
                                        class="dropdown-item" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modal{{$item->id}}"
                                    >
                                        {{__('Edit')}}
                                    </button>
                                </li>

                                <li>
                                    <form method="POST" action="/dashboard/biolink/delete-item/{{$item->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">
                                            {{__('Delete')}}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @include('components.link_items.EditLinkItem')
    @endforeach
</div>

<script>
    const draggables = document.querySelectorAll(".draggable");
    const containers = document.querySelectorAll(".bioLinkItems");

    draggables.forEach((draggable) => {
        draggable.addEventListener("dragstart", () => {
            draggable.classList.add("dragging");
        });

        draggable.addEventListener("dragend", async () => {
            draggable.classList.remove("dragging");

            let bioLInk = window.idSelector("bioLinkItems");
            let elements = bioLInk.getElementsByTagName("div");
            let updatedItem = [];
            for (let i = 0; i < elements.length; i++) {
                const element = elements[i];
                const id = parseInt(element.dataset.item_id);
                updatedItem.push({ id, position: i + 1 });
            }

            await axios.put(`/dashboard/biolink/update-position`, {
                linkItems: updatedItem,
            });
            window.location.reload();
        });
    });

    containers.forEach((container) => {
        container.addEventListener("dragover", (e) => {
            e.preventDefault();
            const afterElement = getDragAfterElement(container, e.clientY);
            const draggable = document.querySelector(".dragging");
            if (afterElement == null) {
                container.appendChild(draggable);
            } else {
                container.insertBefore(draggable, afterElement);
            }
        });
    });

    function getDragAfterElement(container, y) {
        const draggableElements = [
            ...container.querySelectorAll(".draggable:not(.dragging)"),
        ];

        return draggableElements.reduce(
            (closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child };
                } else {
                    return closest;
                }
            },
            { offset: Number.NEGATIVE_INFINITY }
        ).element;
    }
</script>
