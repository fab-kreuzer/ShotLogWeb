<div class="modal fade modal-style" id="addTrainingModal" tabindex="-1" aria-labelledby="addTrainingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTrainingModalLabel">Neues Training hinzufügen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/addTraining" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="desc" class="form-label">Beschreibung</label>
                        <input type="text" class="form-control" id="desc" name="desc" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Ort</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="datetime" class="form-label">Datum/Zeit</label>
                        <input type="datetime-local" class="form-control" id="datetime" name="datetime" required>
                    </div>
                    <button type="button" class="btn btn-primary bg-dark-green mb-3" id="add-series">+</button>

                    <!-- Tabs for Series -->
                    <ul class="nav nav-tabs" id="seriesTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="series-tab-1" data-bs-toggle="tab" data-bs-target="#series-1" type="button" role="tab" aria-controls="series-1" aria-selected="true">Serie 1</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="seriesTabContent">
                        <div class="tab-pane fade show active" id="series-1" role="tabpanel" aria-labelledby="series-tab-1">
                            <button type="button" class="btn btn-secondary bg-dark-green mt-3 mb-3" onclick="addSchuss(1)">+</button>
                            <div id="schuss-container-1" class="row schuss-container">
                                <div class="col-3 mb-3">
                                    <label for="schuss-1-1" class="form-label">Schuss 1</label>
                                    <input type="number" class="form-control" id="schuss-1-1" name="series[0][schuss][0]" step="0.1" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-primary bg-dark-green">Speichern</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let seriesCount = 1;
    let maxSchuss = 10;

    function addSchuss(seriesId) {
        const schussContainer = document.getElementById(`schuss-container-${seriesId}`);
        const schussCount = schussContainer.children.length;

        if (schussCount < maxSchuss) {
            const newSchuss = document.createElement('div');
            newSchuss.classList.add('col-3', 'mb-3');
            newSchuss.innerHTML = `
                <label for="schuss-${seriesId}-${schussCount + 1}" class="form-label">Schuss ${schussCount + 1}</label>
                <input type="number" class="form-control" id="schuss-${seriesId}-${schussCount + 1}" name="series[${seriesId - 1}][schuss][${schussCount}]" step="0.1" required>
            `;
            schussContainer.appendChild(newSchuss);
        } else {
            alert(`Maximal ${maxSchuss} Schüsse pro Serie erlaubt.`);
        }
    }

    document.getElementById('add-series').addEventListener('click', () => {
        seriesCount++;

        const seriesTab = document.getElementById('seriesTab');
        const seriesTabContent = document.getElementById('seriesTabContent');

        // Create new tab
        const newTab = document.createElement('li');
        newTab.classList.add('nav-item');
        newTab.role = 'presentation';
        newTab.innerHTML = `
            <button class="nav-link" id="series-tab-${seriesCount}" data-bs-toggle="tab" data-bs-target="#series-${seriesCount}" type="button" role="tab" aria-controls="series-${seriesCount}" aria-selected="false">Serie ${seriesCount}</button>
        `;
        seriesTab.appendChild(newTab);

        // Create new tab content
        const newTabPane = document.createElement('div');
        newTabPane.classList.add('tab-pane', 'fade');
        newTabPane.id = `series-${seriesCount}`;
        newTabPane.role = 'tabpanel';
        newTabPane.setAttribute('aria-labelledby', `series-tab-${seriesCount}`);
        newTabPane.innerHTML = `
            <button type="button" class="btn btn-secondary bg-dark-green mt-3 mb-3"" onclick="addSchuss(${seriesCount})">+</button>
            <div id="schuss-container-${seriesCount}" class="row schuss-container">
                <div class="col-3 mb-3">
                    <label for="schuss-${seriesCount}-1" class="form-label">Schuss 1</label>
                    <input type="number" class="form-control" id="schuss-${seriesCount}-1" name="series[${seriesCount - 1}][schuss][0]" step="0.1" required>
                </div>
            </div>
        `;
        seriesTabContent.appendChild(newTabPane);

        // Activate the new tab
        const tabTrigger = new bootstrap.Tab(document.getElementById(`series-tab-${seriesCount}`));
        tabTrigger.show();
    });
</script>
