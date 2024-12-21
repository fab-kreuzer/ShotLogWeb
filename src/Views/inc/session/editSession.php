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
                        <label for="ort" class="form-label">Ort</label>
                        <input type="text" class="form-control" id="location" name="ort" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_at" class="form-label">Datum/Zeit</label>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-primary bg-dark-green">Speichern</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>