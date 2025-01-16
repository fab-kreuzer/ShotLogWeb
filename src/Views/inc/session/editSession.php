<div class="modal fade modal-style" id="editSessionModal" tabindex="-1" aria-labelledby="editSessionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSessionModalLabel">Session ändern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/updateSession" method="post"> <!-- Redirects to new handler -->
                <div class="modal-body">
                    <input type="hidden" name="sessionId" id="sessionId">
                    <div class="mb-3">
                        <label for="desc" class="form-label">Beschreibung</label>
                        <input type="text" class="form-control" id="desc" name="desc" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Ort</label>
                        <input type="text" class="form-control" id="location" name="ort" required>
                    </div>
                    <div class="mb-3">
                        <label for="datetime" class="form-label">Datum/Zeit</label>
                        <input type="datetime-local" class="form-control" id="datetime" name="start_at" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Art</label>
                        <div class="btn-group pad-left" role="group" aria-label="Session Type">
                            <input type="radio" class="btn-check" name="isWettkampf" id="wettkampf" value="1" autocomplete="off" required>
                            <label class="btn btn-outline-success" for="wettkampf">
                                <i class="bi bi-trophy"></i> Wettkampf
                            </label>
                            <input type="radio" class="btn-check" name="isWettkampf" id="training" value="0" autocomplete="off">
                            <label class="btn btn-outline-success" for="training">
                                <i class="bi bi-person"></i> Training
                            </label>
                        </div>
                    </div>

                    <!-- Series and Shots -->
                    <ul class="nav nav-tabs" id="editSeriesTab" role="tablist"></ul>
                    <div class="tab-content" id="editSeriesTabContent"></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-primary bg-dark-green">Speichern</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editButtons = document.querySelectorAll('#edit-session');

        editButtons.forEach(button => {
            button.addEventListener('click', async () => {
                const sessionId = button.getAttribute('data-session-id');
                const desc = button.getAttribute('data-desc');
                const ort = button.getAttribute('data-ort');
                const isWettkampf = button.getAttribute('data-isWettkampf');
                const startAt = button.getAttribute('data-startAt');

                // Populate basic session data
                document.querySelector('#editSessionModal #sessionId').value = sessionId;
                document.querySelector('#editSessionModal #desc').value = desc;
                document.querySelector('#editSessionModal #location').value = ort;
                document.querySelector('#editSessionModal #datetime').value = startAt;

                if (isWettkampf === '1') {
                    document.querySelector('#editSessionModal #wettkampf').checked = true;
                } else {
                    document.querySelector('#editSessionModal #training').checked = true;
                }

                // Fetch series and shots
                try {
                    const response = await fetch(`/api/getTrainingData?sessionId=${sessionId}`);
                    const result = await response.json();
                    const series = result.data.series;
                    const seriesTab = document.getElementById('editSeriesTab');
                    const seriesTabContent = document.getElementById('editSeriesTabContent');
                    seriesTab.innerHTML = '';
                    seriesTabContent.innerHTML = '';

                    series.forEach((series, index) => {
                        const tabId = `series-${index + 1}`;
                        const activeClass = index === 0 ? 'active' : '';

                        // Add tab
                        const tab = document.createElement('li');
                        tab.classList.add('nav-item');
                        tab.innerHTML = `
                        <button class="nav-link ${activeClass}" id="edit-tab-${tabId}" data-bs-toggle="tab" data-bs-target="#edit-${tabId}" type="button" role="tab" aria-controls="edit-${tabId}" aria-selected="${index === 0}">
                            Serie ${index + 1}
                        </button>`;
                        seriesTab.appendChild(tab);

                        // Add tab content
                        const seriesDiv = document.createElement('div');
                        seriesDiv.classList.add('tab-pane', 'fade', 'show');
                        if (index === 0) {
                            seriesDiv.classList.add('active');
                        }
                        seriesDiv.id = `edit-${tabId}`;
                        seriesDiv.setAttribute('role', `tabpanel`);
                        seriesDiv.setAttribute('aria-labelledby', `edit-tab-${index + 1}`);

                        // Add shots
                        series.schusse.forEach((schuss, i) => {
                            const schussRow = document.createElement('div');
                            schussRow.classList.add('row', 'align-items-center', 'mb-3');
                            schussRow.id = `schuss-row-${schuss.id}`;

                            schussRow.innerHTML = `
                            <div class="col-4">
                                <label for="schuss-${index + 1}-${i + 1}" class="form-label">Schuss ${i + 1}</label>
                                <input type="number" class="form-control" id="schuss-${index + 1}-${i + 1}" name="series[${index}][schuss][${i}]" value="${schuss.wert}" step="0.1" required>
                            </div>
                            `;

                            seriesDiv.appendChild(schussRow);
                        });

                        seriesTabContent.appendChild(seriesDiv);
                    });
                } catch (error) {
                    console.error('Error fetching session details:', error);
                }
            });
        });
    });
</script>
