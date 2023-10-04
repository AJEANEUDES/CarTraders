<form action="{{ route('modeles-voitures.store.gestion') }}" method="post" id="modeles-voitures-store-gestion">
    @csrf
    <div class="modal fade" id="addModeleModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">AJOUT D'UN NOUVEAU MODELE</h4>
                </div>
                <div class="modal-body">
                    <label for="nom_modele" class="form-label">Nom du modele</label>
                    <input type="text" style="height: 55px;border-radius: 10px;" name="nom_modele" id="nom_modele"
                        class="form-control form-control-lg" />
                    <label for="nom_modele" class="form-label mt-3">Marque du modele</label>
                    <select style="height: 55px;border-radius: 10px;" name="marque_id" id="marque_id"
                        class="form-control form-control-lg ">
                        <option selected disabled>-- Selectionnez la marque --</option>
                        @foreach ($marques as $marque)
                            <option value="{{ $marque->id_marque }}">{{ $marque->nom_marque }}</option>
                        @endforeach
                    </select>
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