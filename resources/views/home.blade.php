@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-4">
        <h1>Bem vindo ao gerenciador de RPG</h1>
        <p>Aqui é o dashboard para administrar seus personagens, skills, inventário e mais.</p>

        <div class="row">
            <div class="col-md-12">
                <h3>Parties</h3>
                <!-- Party List -->
                <ul id="party-list" class="list-group mb-4">
                    <!-- Dynamic content populated with JavaScript -->
                </ul>

                <!-- Add New Party Character Form -->
                <h4>Add Character to Party</h4>
                <form id="add-party-form">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="character_id" class="form-label">Character</label>
                            <select id="character_id" class="form-control" required>
                                <!-- Populate with characters -->
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="hitpoints" class="form-label">Hitpoints</label>
                            <input type="number" id="hitpoints" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label for="mana" class="form-label">Mana</label>
                            <input type="number" id="mana" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label for="order" class="form-label">Order</label>
                            <input type="number" id="order" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Character</button>
                </form>
            </div>
        </div>
    </div>
<!-- Character Details Modal -->
<div class="modal fade" id="character-modal" tabindex="-1" aria-labelledby="characterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="characterModalLabel">Character Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Character details will be injected here via JavaScript -->
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            loadParties();
            loadCharacters();

            // Initialize SortableJS on #party-list
            const sortable = new Sortable(document.getElementById('party-list'), {
                animation: 150,
                onEnd: function (event) {
                    const updatedOrder = Array.from(event.target.children).map((li, index) => {
                        return {
                            id: li.getAttribute('data-id'),
                            order: index + 1 // Adjust order starting from 1
                        };
                    });

                    // Send updated order to the server
                    fetch('/api/parties/reorder', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ order: updatedOrder })
                    }).then(response => response.json())
                    .then(data => {
                        console.log('Order updated!');
                    });
                }
            });

            function loadCharacters() {
                fetch('/api/characters')
                    .then(response => response.json())
                    .then(characters => {
                        const characterSelect = document.getElementById('character_id');
                        characters.forEach(character => {
                            const option = document.createElement('option');
                            option.value = character.id;
                            option.textContent = character.name; // Display character name
                            characterSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching characters:', error));
            }

            function calculateLevel(experience, baseExperience = 10, exponent = 2) {
                return Math.floor(Math.pow(experience / baseExperience, 1 / exponent));
            }
            function calculateMaxExperience(level, baseExperience = 10, exponent = 2) {
                return baseExperience * Math.pow(level, exponent);
            }
            // Fetch and display parties
            function loadParties() {
                fetch('/api/parties')
                .then(response => response.json())
                .then(parties => {
                    const partyList = document.getElementById('party-list');
                    partyList.innerHTML = '';

                    parties.forEach(party => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center', 'party-group');
                        li.setAttribute('data-id', party.id); // Attach data-id for sorting

                        // Access character data from the party object
                        const character = party.character;

                        // Check if character exists before accessing its properties
                        if (character) {
                            const imagePath = `/storage/${character.image_path}`; // Set the image path
                            // Calculate hitpoints, mana, and experience as a percentage
                            const hpPercentage = (party.hitpoints / character.hitpoints) * 100;
                            const manaPercentage = (party.mana / character.mana) * 100; // Assuming 'mana' in character

                            const level = calculateLevel(character.exp);
                            const maxExperience = calculateMaxExperience(level);
                            const expPercentage = (maxExperience / character.exp) * 100;
                            console.log(expPercentage, maxExperience, level, character.exp );


                            li.innerHTML = `
                                <div style="width: 100%;" class="character-party-panel">
                                    <div class="character-info" data-character-id="${character.id}">
                                        <img src="${imagePath}" alt="${character.name}" width="50" height="50">
                                        <strong>${character.name}</strong>
                                        <strong>Level:${level}</strong>
                                        <strong>Class:</strong> ${character.class}
                                        <strong>Race:</strong> ${character.race}
                                    </div>

                                    <div class="status-bars">
                                        <label>Hitpoints: </label>
                                        <input type="number" value="${party.hitpoints}" data-type="hitpoints" class="form-control hitpoint-input" data-party-id="${party.id}" />
                                        <span>(${character.hitpoints})</span>
                                        <div class="progress hitpoints-bar">
                                            <div class="progress-bar bg-danger" style="width: ${hpPercentage}%"></div>
                                        </div>

                                        <label>Mana: </label>
                                        <input type="number" value="${party.mana}" data-type="mana" class="form-control mana-input" data-party-id="${party.id}" />
                                        <span>(${character.mana})</span>
                                        <div class="progress mana-bar">
                                            <div class="progress-bar bg-primary" style="width: ${manaPercentage}%"></div>
                                        </div>
                                    </div>
                                    <div class="root-exp-bar">
                                        <label>Exp: </label>
                                        <input type="number" value="${character.exp}" data-type="exp" class="form-control exp-input" data-character-id="${character.id}" />
                                        <span>(${Math.round(expPercentage)} / ${character.exp})</span>
                                        <div class="progress exp-bar">
                                            <div class="progress-bar bg-warning" style="width: ${expPercentage}%"></div>
                                        </div>
                                    </div>

                                    <button class="btn btn-danger btn-sm remove-character-button" onclick="deleteParty(${party.id})">Remove</button>
                                </div>
                            `;
                            const characterInfo = li.querySelector('.character-info');
                            characterInfo.addEventListener('click', function() {
                                const characterId = this.getAttribute('data-character-id');
                                showCharacterDetails(characterId);
                            });
                        } else {
                            li.innerHTML = `
                                <div>
                                    <strong>Character data missing!</strong> <br>
                                    <strong>Current Hitpoints:</strong> ${party.hitpoints} <br>
                                    <strong>Mana:</strong> ${party.mana} <br>
                                    <strong>Order:</strong> ${party.order}
                                </div>
                                <div>
                                    <button class="btn btn-danger btn-sm" onclick="deleteParty(${party.id})">Remove</button>
                                </div>
                            `;
                        }
                        partyList.appendChild(li);
                    });

                    // Add event listeners for updating the values
                    document.querySelectorAll('.hitpoint-input, .mana-input, .exp-input, .order-input').forEach(input => {
                        input.addEventListener('change', (event) => {
                            const partyId = event.target.getAttribute('data-party-id');
                            const characterId = event.target.getAttribute('data-character-id');
                            const valueType = event.target.getAttribute('data-type');
                            const newValue = event.target.value;

                            // Determine the API endpoint based on value type
                            let url = '';
                            let data = {};
                            if (valueType === 'hitpoints' || valueType === 'mana' || valueType === 'order') {
                                console.log('hitpoint mana or order changed');
                                url = `/api/parties/${partyId}`;
                                data[valueType] = newValue;
                            } else if (valueType === 'exp') {
                                console.log('experience changed');
                                url = `/api/characters/${characterId}`;
                                data[valueType] = newValue;
                            }

                            // Send the update request
                            fetch(url, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify(data),
                            })
                            .then(response => response.json())
                            .then(updatedData => {
                                console.log(`Updated ${valueType} successfully`, updatedData);
                                loadParties(); // Reload the parties list to reflect updated values
                            })
                            .catch(error => console.error('Error updating value:', error));
                        });
                    });
                });
            }


            // Handle form submission to add new party character
            document.getElementById('add-party-form').addEventListener('submit', function (e) {
                e.preventDefault();

                const character_id = document.getElementById('character_id').value;
                const hitpoints = document.getElementById('hitpoints').value;
                const mana = document.getElementById('mana').value;
                const order = document.getElementById('order').value;

                fetch('/api/parties', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        character_id,
                        hitpoints,
                        mana,
                        order
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert('Party character added!');
                    loadParties(); // Refresh party list
                });
            });

            // Delete a party
            function deleteParty(id) {
                fetch(`/api/parties/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    alert('Party character removed!');
                    loadParties(); // Refresh party list
                });
            }
        });


function showCharacterDetails(characterId) {
    fetch(`/api/characters/${characterId}`)
        .then(response => response.json())
        .then(character => {
            if (character) {
                // Get the modal elements
                const modal = document.getElementById('character-modal');
                const modalBody = modal.querySelector('.modal-body');

                // Generate the inventory grid
                let inventoryHTML = '<strong>Inventory:</strong><div class="inventory-grid">';
                character.inventory.items.forEach(item => {
                    const imagePath = item.image_path ? `/storage/${item.image_path}` : '/path/to/default/image.jpg';
                    inventoryHTML += `
                        <div>
                            <div class="inventory-item" tabindex="0"
                                data-bs-toggle="popover"
                                data-bs-trigger="hover focus"
                                data-bs-html="true"
                                data-bs-content="<strong>${item.name}</strong><br>Quantity: ${item.pivot.quantity}<br>${item.description}">
                                <img src="${imagePath}" alt="${item.name}">
                                <p class="item-quantity">Quantity: ${item.pivot.quantity}</p>
                            </div>
                        </div>
                    `;
                });
                inventoryHTML += '</div>';

                // Generate the skills grid
                let skillsHTML = '<strong>Skills:</strong><div class="skills-grid">';
                character.skills.forEach(skill => {
                    const skillImagePath = skill.image_path ? `/storage/${skill.image_path}` : '/path/to/default/skill_image.jpg';
                    skillsHTML += `
                        <div>
                            <div class="skill-icon" tabindex="0"
                                data-bs-toggle="popover"
                                data-bs-trigger="hover focus"
                                data-bs-html="true"
                                data-bs-content="<strong>${skill.name}</strong><br>Level: ${skill.pivot.level}<br>${skill.description}">
                                <img src="${skillImagePath}" alt="${skill.name}">
                                <p class="skill-level">Level: ${skill.pivot.level}</p>
                            </div>
                        </div>
                    `;
                });
                skillsHTML += '</div>';

                // Set the modal content
                modalBody.innerHTML = `
                    <div>
                        <h4>${character.name}</h4>
                        <strong>Class:</strong> ${character.class} <br>
                        <strong>Race:</strong> ${character.race} <br>
                        <strong>Description:</strong> ${character.description} <br>
                        ${skillsHTML}
                        ${inventoryHTML}
                    </div>
                `;

                // Initialize popovers for the inventory and skill items
                const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
                const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl);
                });

                // Show the modal
                const bootstrapModal = new bootstrap.Modal(modal);
                bootstrapModal.show();
            }
        })
        .catch(error => {
            console.error('Error fetching character details:', error);
        });
}


    </script>
    <style>
.character-info {
    margin-bottom: 0px;
}

.status-bars {
    /* margin-top: 10px;
    margin-bottom: 10px; */
    flex: 1;
    font-size: smaller;
}

.progress {
    /* height: 25px; */
    /* margin-bottom: 10px; */
    border-radius: 15px;
    background-color: #e9ecef;
    overflow: hidden;
}

.progress-bar {
    font-size: 12px;
    line-height: 25px;
    text-align: center;
    border-radius: 15px;
    background-image: linear-gradient(45deg, rgba(255,255,255,0.2) 25%, transparent 25%, transparent 50%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0.2) 75%, transparent 75%, transparent);
    background-size: 1.5rem 1.5rem;
    background-position: 0 0;
    transition: width 0.6s ease;
}

.progress-bar.bg-danger {
    background-color: #dc3545;
}

.progress-bar.bg-primary {
    background-color: #007bff;
}

.progress-bar.bg-warning {
    background-color: #ffc107;
}

.form-control {
    width: 70px;
    margin-bottom: 10px;
    display: inline-block;
    border-radius: 8px;
    text-align: center;
}

.character-party-panel {
    width: 100%;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    gap: 20px;
    background-color: #b3b6b9;
    padding: 15px;
    border-radius: 20px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

.character-party-panel:hover {
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
}

.character-info img {
    border-radius: 50%;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.character-info strong {
    display: block;
    font-size: 1.2em;
    color: #333;
    margin-top: 5px;
}

.button-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    border-radius: 10px;
}

.button-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}
.party-group{
    background-color: #ed143d00;
    border: none;
}
.remove-character-button{
    position: absolute;
    right: 0;
    transform: translateY(-10px);
}
.root-exp-bar{
    position: absolute;
    bottom: 0;
    width: inherit;
    text-align: center;
    left: 0px;
    right: 0px;
    padding-right: 40px;
    padding-left: 40px;
}


    </style>
@endsection
