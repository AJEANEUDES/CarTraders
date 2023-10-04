<form action="{{ route('marques-voitures.store') }}" method="post" id="marques-voitures-store">
    @csrf
    <div class="modal fade" id="addMarqueModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">AJOUT D'UNE NOUVELLE MARQUE</h4>
                </div>
                <div class="modal-body">
                    <label for="nom_marque" class="form-label">Nom de la marque</label>
                    <input type="text" style="height: 55px;border-radius: 10px;" name="nom_marque" id="nom_marque"
                        class="form-control form-control-lg" />
                </div>
                <div class="modal-footer">
                    <button type="button" style="border-radius: 10px;" class="btn btn-danger btn-md"
                        data-bs-dismiss="modal"> <i class="bx bx-exit"></i> Annuler</button>
                    <button type="submit" style="border-radius: 10px;" class="btn btn-success btn-md"><i
                            class="bx bx-save"></i> Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</form>