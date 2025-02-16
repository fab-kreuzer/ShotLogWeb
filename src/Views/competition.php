<?php ob_start(); ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Wettkampf</h1>
        <button id="add-training-button" class="btn bg-dark-green" data-bs-toggle="modal" data-bs-target="#editSessionModal">
            Wettkampf hinzufügen
        </button>
    </div>
    <p>Hier kannst du deine Wettkämpfe verwalten.</p>
</div>

<script>
    document.getElementById('add-training-button').addEventListener('click', () => {
        // Clear hidden session id (so backend knows it's new)
        document.getElementById('sessionId').value = '';
        // Clear text fields
        document.getElementById('desc').value = '';
        document.getElementById('location').value = '';
        document.getElementById('datetime').value = '';
        // Reset radio buttons if applicable
        document.getElementById('wettkampf').checked = true;

        // Clear series and shots
        const seriesTab = document.getElementById('editSeriesTab');
        const seriesTabContent = document.getElementById('editSeriesTabContent');
        seriesTab.innerHTML = '';
        seriesTabContent.innerHTML = '';
        // Reset series count
        seriesCount = 1;

        // Initialize default series tab with one shot
        const defaultTab = document.createElement('li');
        defaultTab.classList.add('nav-item');
        defaultTab.innerHTML = `
            <button class="nav-link active" id="series-tab-1" data-bs-toggle="tab" data-bs-target="#series-1" type="button" role="tab" aria-controls="series-1" aria-selected="true">
              Serie 1
            </button>
        `;
        seriesTab.appendChild(defaultTab);

        const defaultTabPane = document.createElement('div');
        defaultTabPane.classList.add('tab-pane', 'fade', 'show', 'active');
        defaultTabPane.id = 'series-1';
        defaultTabPane.setAttribute('role', 'tabpanel');
        defaultTabPane.setAttribute('aria-labelledby', 'series-tab-1');
        defaultTabPane.innerHTML = `
            <button type="button" class="btn btn-secondary bg-dark-green mt-3 mb-3" onclick="addSchuss(0)">+ Schuss</button>
            <div id="schuss-container-0" class="row schuss-container">
                <div class="row align-items-center mb-3">
                    <div class="col-4">
                        <label for="schuss-0-1" class="form-label">Schuss 1</label>
                        <input type="number" class="form-control" id="schuss-0-1" name="series[0][schuss][0]" step="0.1" required>
                    </div>
                </div>
            </div>
        `;
        seriesTabContent.appendChild(defaultTabPane);
    });
</script>



<?php
    //Include Sessions view
    include 'inc/competition/display_comp_sessions.php';
    include 'inc/session/editSession.php';
?>

<?php 
    $content = ob_get_clean();
    include 'inc/layout.php';
?>