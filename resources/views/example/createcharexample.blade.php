<form action="{{ route('characters.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Character Name">
    <input type="text" name="description" placeholder="Description">
    <!-- Add other character fields here -->

    <h4>Inventory</h4>
    <div id="items">
        <div>
            <select name="items[0][item_id]">
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <input type="number" name="items[0][quantity]" placeholder="Quantity" value="1">
        </div>
    </div>

    <button type="button" id="addItem">Add Item</button>
    <button type="submit">Create Character</button>
</form>

<script>
    let itemCount = 1;
    document.getElementById('addItem').addEventListener('click', function() {
        const itemsDiv = document.getElementById('items');
        const newItemDiv = document.createElement('div');

        newItemDiv.innerHTML = `
            <select name="items[${itemCount}][item_id]">
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <input type="number" name="items[${itemCount}][quantity]" placeholder="Quantity" value="1">
        `;

        itemsDiv.appendChild(newItemDiv);
        itemCount++;
    });
</script>
