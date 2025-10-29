const getServicios = () => {
    fetch('obtener_servicios.php')
    .then(response => response.json())
    .then(data => {
       // const lista = document.getElementById('listaServicios');
        data.forEach(servicio => {
            console.log('servicio', servicio)
        //    const li = document.createElement('li');
          //  li.textContent = `${servicio.nombre} - ${servicio.precio}`;
            //lista.appendChild(li);
        });
    })
    .catch(error => console.error('Error:', error));
}