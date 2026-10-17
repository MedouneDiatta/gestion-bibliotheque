<!-- Lien pour revenir en arrière -->
<p><a href="/Bibliotech/documents">← Retour à la liste des documents</a></p>

<h2>Ajouter un nouveau document</h2>

<!-- Formulaire pointant vers la route de traitement (POST) -->
<form action="/Bibliotech/documents/store" method="POST" style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
    
    <div style="margin-bottom: 15px;">
        <label for="titre" style="display: block; font-weight: bold; margin-bottom: 5px;">Titre :</label>
        <input type="text" id="titre" name="titre" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="annee" style="display: block; font-weight: bold; margin-bottom: 5px;">Année de publication :</label>
        <input type="number" id="annee" name="annee" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="type" style="display: block; font-weight: bold; margin-bottom: 5px;">Type de document :</label>
        <select id="type" name="type" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="livre">Livre</option>
            <option value="dvd">DVD</option>
        </select>
    </div>

    <!-- Champs spécifiques pour le Livre (par exemple) -->
    <div style="margin-bottom: 15px;">
        <label for="auteur" style="display: block; font-weight: bold; margin-bottom: 5px;">Auteur (si livre) :</label>
        <input type="text" id="auteur" name="auteur" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="editeur" style="display: block; font-weight: bold; margin-bottom: 5px;">Éditeur (si livre) :</label>
        <input type="text" id="editeur" name="editeur" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <button type="submit" style="background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold;">
        Enregistrer le document
    </button>
</form>
