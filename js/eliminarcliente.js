function deleteClient(id) {
    $.ajax({
      url: 'clientes.php',
      type: 'POST',
      data: { delete: 1, cl_id: id },
      dataType: 'json',
      success: function(response) {
        if (response.Status === 200) {
          alertify.success('Se ha eliminado el registro');
          location.reload();
        } else {
          alertify.error('No se encontró el registro');
        }
      },
      error: function(xhr, status, error) {
        alertify.error('Error al realizar la solicitud: ' + error);
      }
    });
  }
  