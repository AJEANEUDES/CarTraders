<form action="{{ route('societes.store') }}" method="post" id="societes-store">
    @csrf
    <div class="modal fade" id="addSocieteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">AJOUT D'UNE NOUVELLE SOCIETE</h4>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-12">
                        <label for="nom_societe" class="form-label">Nom de la societe</label>
                        <input type="text" style="height: 55px;border-radius: 10px;" name="nom_societe" id="nom_societe"
                            class="form-control form-control-lg" />
                    </div>
                    <div class="col-md-12">
                        <label for="adresse_societe" class="form-label">Adresse de la societe</label>
                        <input type="text" style="height: 55px;border-radius: 10px;" name="adresse_societe"
                            id="adresse_societe" class="form-control form-control-lg" />
                    </div>
                    <div class="col-md-6">
                        <label for="telephone_societe1" class="form-label">Telephone 1</label>
                        <input type="number" min="0" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="telephone_societe1" id="telephone_societe1">
                    </div>
                    <div class="col-md-6">
                        <label for="telephone_societe2" class="form-label">Telephone 2</label>
                        <input type="number" min="0" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="telephone_societe2" id="telephone_societe2">
                    </div>
                    <div class="col-md-12">
                        <label for="parking_id" class="form-label">Parc de la societe</label>
                        <select type="text" style="height: 55px;border-radius: 10px;" name="parking_id" id="parking_id"
                            class="form-control form-control-lg">
                            <option selected disabled>-- Selectionnez le parc de la societe --</option>
                            @foreach ($parkings as $parking)
                                <option value="{{ $parking->id_parking }}">{{ $parking->nom_parking }}</option>
                            @endforeach
                        </select>
                    </div>
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