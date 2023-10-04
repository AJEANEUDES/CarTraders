<form action="{{ route('voitures.store') }}" method="post" enctype="multipart/form-data" id="voitures-store">
    @csrf
    <div class="modal fade" id="addVoitureModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">AJOUT D'UNE NOUVELLE VOITURE</h4>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label for="marque_id" class="form-label">Marque de la voiture</label>
                        <select style="height: 55px;border-radius: 10px;" class="form-control form-control-lg"
                            name="marque_id" id="marque_id">
                            <option selected disabled>-- Selectionnez --</option>
                            @foreach ($marques as $marque)
                            <option value="{{ encodeId($marque->id_marque) }}">{{ Str::upper($marque->nom_marque) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="modele_id" class="form-label">Modele de la voiture</label>
                        <select style="height: 55px;border-radius: 10px;text-transform: uppercase;"
                            class="form-control form-control-lg" name="modele_id" id="modele_id"></select>
                    </div>
                    <div class="col-md-6">
                        <label for="parking_id" class="form-label">Parc de la voiture</label>
                        <select style="height: 55px;border-radius: 10px;" class="form-control form-control-lg"
                            name="parking_id" id="parking_id">
                            <option selected disabled>-- Selectionnez le parc --</option>
                            @foreach ($parkings as $parking)
                            <option value="{{ encodeId($parking->id_parking) }}">{{ Str::upper($parking->nom_parking) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="societe_id" class="form-label">Societe de la voiture</label>
                        <select style="height: 55px;border-radius: 10px;text-transform: uppercase;"
                            class="form-control form-control-lg" name="societe_id" id="societe_id">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="annee_voiture" class="form-label">Année</label>
                        <input type="number" min="0" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="annee_voiture" id="annee_voiture">
                    </div>
                    <div class="col-md-4">
                        <label for="kilometrage_voiture" class="form-label">Kilometrage</label>
                        <input type="number" min="0" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="kilometrage_voiture" id="kilometrage_voiture">
                    </div>
                    <div class="col-md-4">
                        <label for="date_mise_circul_voiture" class="form-label">Date de mise en circulation</label>
                        <input type="date" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="date_mise_circul_voiture"
                            id="date_mise_circul_voiture">
                    </div>
                    <div class="col-md-4">
                        <label for="carburant_voiture" class="form-label">Carburant</label>
                        <select style="height: 55px;border-radius: 10px;" class="form-control form-control-lg"
                            name="carburant_voiture" id="carburant_voiture">
                            <option selected disabled>-- Selectionnez --</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Essence">Essence</option>
                            <option value="Hybride">Hybride</option>
                            <option value="Electrique">Electrique</option>
                            <option value="GLP">GLP</option>
                            <option value="GNV">GNV</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="boite_vitesse_voiture" class="form-label">Boite de vitesse</label>
                        <select style="height: 55px;border-radius: 10px;" class="form-control form-control-lg"
                            name="boite_vitesse_voiture" id="boite_vitesse_voiture">
                            <option selected disabled>-- Selectionnez --</option>
                            <option value="Manuelle">Manuelle</option>
                            <option value="Automatique">Automatique</option>
                            <option value="Robotisée">Robotisée</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="nbres_place_voiture" class="form-label">Nombre de place</label>
                        <select style="height: 55px;border-radius: 10px;" class="form-control form-control-lg"
                            name="nbres_place_voiture" id="nbres_place_voiture">
                            <option selected disabled>-- Selectionnez --</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="interieur_voiture" class="form-label">Interieur de la voiture (couleur)</label>
                        <input type="text" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="interieur_voiture" id="interieur_voiture">
                    </div>
                    <div class="col-md-4">
                        <label for="exterieur_voiture" class="form-label">Exterieur de la voiture (couleur)</label>
                        <input type="text" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="exterieur_voiture" id="exterieur_voiture">
                    </div>
                    <div class="col-md-4">
                        <label for="puissance_voiture" class="form-label">Puissance de la voiture</label>
                        <input type="text" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="puissance_voiture" id="puissance_voiture">
                    </div>
                    <div class="col-md-6">
                        <label for="prix_voiture" class="form-label">Prix de la voiture</label>
                        <input type="number" min="0" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="prix_voiture" id="prix_voiture">
                    </div>
                    <div class="col-md-6">
                        <label for="image_voiture" class="form-label">Image de la voiture</label>
                        <input type="file" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="image_voiture" id="image_voiture">
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