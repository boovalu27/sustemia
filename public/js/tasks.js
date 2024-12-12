// Inicializa los tooltips de Bootstrap
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

function toggleWeeks(elementId) {
    const element = document.getElementById(elementId);
    element.style.display = element.style.display === "none" ? "block" : "none"; // Alterna visibilidad
}

function showTasks(year, area, month, week, event) {
    event.stopPropagation();

    const weekTasks = tasks[year][area][month][week] || [];

    let tasksContent = `<strong>Detalles de la semana ${week} en ${month} (${year} - ${area}):</strong><br>`;
    if (weekTasks.length > 0) {
        tasksContent += `<ul class="list-group">`;
        weekTasks.forEach(task => {
            tasksContent += `<li class="list-group-item">
                                <strong>${task.title}</strong><br>
                                <small>${task.description}</small><br>
                                <small>Fecha: ${new Date(task.due_date).toLocaleDateString()}</small><br>
                                <small>Estado: ${task.status}</small>
                            </li>`;
        });
        tasksContent += `</ul>`;
    } else {
        tasksContent += `<span>No hay tareas en esta semana.</span>`;
    }

    document.getElementById('modalTasksContent').innerHTML = tasksContent;
    var modal = new bootstrap.Modal(document.getElementById('taskModal'));
    modal.show(); // Abre el modal
}
