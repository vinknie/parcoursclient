@extends('master')

@section('content')

<div class="text-center mt-20 mb-4">
    <h1 class="text-2xl font-semibold page-titles">Résultats</h1>
 </div>
 <label for="events">Sélectionnez un événement :</label>
 <select id="events" name="events">
     @foreach($events as $event)
         <option value="{{ $event->id_event }}">{{ $event->name }}</option>
     @endforeach
 </select>
 
 <!-- Conteneur pour les catégories associées à l'événement sélectionné -->
 <div id="categories-container">

     <!-- Les catégories seront chargées ici via JavaScript -->
 </div>






 <script>
$('#events').change(function() {
    var eventId = $(this).val(); // Obtenir la valeur de l'option sélectionnée

    // Effectuer une requête Ajax pour récupérer les catégories et les verbatims associés à l'événement sélectionné
    $.ajax({
        url: '/admin/result/categories', // Mettez à jour l'URL pour correspondre à votre route
        type: 'GET',
        data: {
            eventId: eventId // Transmettre l'ID de l'événement dans la requête
        },
        success: function(data) {
            // Clear the previous content in categories-container
            $('#categories-container').empty();

            // Parcourir les données retournées (catégories et verbatims)
            $.each(data, function(categoryTitle, verbatims) {
    var categoryHTML = '<h2 class="text-2xl font-bold mt-4 mb-2 text-center">' + categoryTitle + '</h2>';
    categoryHTML += '<table class="text-center rounded w-full border"><thead class="bg-gray-800 text-white"><tr><th class="py-3">Verbatim</th><th class="py-3">Positif</th><th class="py-3">Négatif</th></tr></thead><tbody>';

    $.each(verbatims, function(index, verbatim) {
        categoryHTML += '<tr>';
        categoryHTML += '<td class="py-2">' + verbatim.verbatim + '</td>';
        categoryHTML += '<td class="py-2">' + verbatim.positif + '</td>';
        categoryHTML += '<td class="py-2">' + verbatim.negatif + '</td>';
        categoryHTML += '</tr>';
    });

    categoryHTML += '</tbody></table>';

    $('#categories-container').append(categoryHTML);
});
        },
        error: function(error) {
            console.log(error);
        }
    });
});
</script> 

@endsection