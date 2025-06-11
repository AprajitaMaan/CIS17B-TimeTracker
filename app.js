document.addEventListener('DOMContentLoaded', () => {
  const taskForm = document.getElementById('task-form');
  
  taskForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const taskName = document.getElementById('task-name').value;
    
    await fetch('/api/tasks.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action: 'add', name: taskName })
    });
    
    loadTasks();
    taskForm.reset();
  });

  async function loadTasks() {
    const response = await fetch('/api/tasks.php?action=list');
    const tasks = await response.json();
    
    document.getElementById('task-list').innerHTML = tasks.map((task, index) => `
      <div class="task">
        <span>${task.name} (${formatTime(task.totalSeconds)})</span>
        <div>
          ${task.start ? 
            `<button class="stop-btn" onclick="stopTask(${index})">Stop</button>` : 
            `<button class="start-btn" onclick="startTask(${index})">Start</button>`
          }
        </div>
      </div>
    `).join('');
  }

  window.startTask = async (index) => {
    await fetch('/api/tasks.php', {
      method: 'POST',
      body: JSON.stringify({ action: 'start', index })
    });
    loadTasks();
  };

  window.stopTask = async (index) => {
    await fetch('/api/tasks.php', {
      method: 'POST',
      body: JSON.stringify({ action: 'stop', index })
    });
    loadTasks();
  };

  function formatTime(seconds) {
    const hrs = Math.floor(seconds / 3600);
    const mins = Math.floor((seconds % 3600) / 60);
    return `${hrs}h ${mins}m`;
  }

  loadTasks();
});