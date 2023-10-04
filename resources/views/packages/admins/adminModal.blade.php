<form action="{{ route('admins.store') }}" method="post" id="admins-store">
    @csrf
    <div class="modal fade" id="addAdminModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">AJOUT D'UN NOUVEAU ADMIN</h4>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label for="nom_user" class="form-label">Nom</label>
                        <input type="text" style="height: 55px;border-radius: 10px;" name="nom_user" id="nom_user"
                            class="form-control form-control-lg" />
                    </div>
                    <div class="col-md-6">
                        <label for="prenom_user" class="form-label">Prenom</label>
                        <input type="text" style="height: 55px;border-radius: 10px;" name="prenom_user" id="prenom_user"
                            class="form-control form-control-lg" />
                    </div>
                    <div class="col-md-6">
                        <label for="adresse_user" class="form-label">Adresse</label>
                        <input type="text" style="height: 55px;border-radius: 10px;" name="adresse_user" id="adresse_user"
                            class="form-control form-control-lg" />
                    </div>
                    <div class="col-md-6">
                        <label for="telephone_user" class="form-label">Telephone</label>
                        <input type="text" style="height: 55px;border-radius: 10px;" name="telephone_user" id="telephone_user"
                            class="form-control form-control-lg" />
                    </div>
                    <div class="col-md-6">
                        <label for="email_user" class="form-label">Email</label>
                        <input type="text" style="height: 55px;border-radius: 10px;" name="email_user" id="email_user"
                            class="form-control form-control-lg" />
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" style="height: 55px;border-radius: 10px;" name="password" id="password"
                            class="form-control form-control-lg" />
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