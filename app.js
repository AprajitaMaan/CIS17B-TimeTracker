class TimeTracker {
  constructor() {
      this.updateInterval = null;
      this.init();
  }

  init() {
      this.setupEventListeners();
      this.loadTasks();
  }

  setupEventListeners() {
      document.getElementById('task-form').addEventListener('submit', (e) => {
          e.preventDefault();
          this.addTask();
      });
  }

  formatTime(totalSeconds) {
      const hrs = Math.floor(totalSeconds / 3600);
      const mins = Math.floor((totalSeconds % 3600) / 60);
      const secs = totalSeconds % 60;
      return `${hrs}h ${mins.toString().padStart(2, '0')}m ${secs.toString().padStart(2, '0')}s`;
  }

  getCurrentRuntime(task) {
      if (!task.start) return task.totalSeconds;
      return task.totalSeconds + (Math.floor(Date.now() / 1000) - task.start);
  }

  startUpdating() {
      if (this.updateInterval) clearInterval(this.updateInterval);
      this.updateInterval = setInterval(() => this.loadTasks(), 1000);
  }

  async loadTasks() {
      try {
          const response = await fetch('/api/tasks.php?action=list');
          const tasks = await response.json();
          this.renderTasks(tasks);
      } catch (error) {
          console.error('Error loading tasks:', error);
      }
  }

  renderTasks(tasks) {
      const container = document.getElementById('task-list');
      container.innerHTML = tasks.map((task, index) => `
          <div class="task ${task.start ? 'running-task' : ''}">
              <span>${task.name} - ${this.formatTime(this.getCurrentRuntime(task))}</span>
              <div class="task-actions">
                  ${task.start ? 
                      `<button class="btn stop-btn" onclick="timeTracker.stopTask(${index})">Stop</button>` : 
                      `<button class="btn start-btn" onclick="timeTracker.startTask(${index})">Start</button>`
                  }
                  <button class="btn delete-btn" onclick="timeTracker.deleteTask(${index})">Delete</button>
              </div>
          </div>
      `).join('');
  }

  async addTask() {
      const taskName = document.getElementById('task-name').value.trim();
      if (!taskName) return;

      try {
          await fetch('/api/tasks.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ action: 'add', name: taskName })
          });
          this.loadTasks();
          document.getElementById('task-form').reset();
      } catch (error) {
          console.error('Error adding task:', error);
      }
  }

  async startTask(index) {
      try {
          await fetch('/api/tasks.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ action: 'start', index })
          });
          this.startUpdating();
      } catch (error) {
          console.error('Error starting task:', error);
      }
  }

  async stopTask(index) {
      try {
          await fetch('/api/tasks.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ action: 'stop', index })
          });
          if (this.updateInterval) clearInterval(this.updateInterval);
          this.loadTasks();
      } catch (error) {
          console.error('Error stopping task:', error);
      }
  }

  async deleteTask(index) {
      if (!confirm('Delete this task?')) return;
      try {
          await fetch('/api/tasks.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ action: 'delete', index })
          });
          this.loadTasks();
      } catch (error) {
          console.error('Error deleting task:', error);
      }
  }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
  window.timeTracker = new TimeTracker();
});