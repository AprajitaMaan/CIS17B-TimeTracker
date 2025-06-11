document.addEventListener("DOMContentLoaded", function () {
    const taskForm = document.getElementById("taskForm");
    const taskList = document.getElementById("taskList");
  
    taskForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const name = document.getElementById("taskName").value;
      fetch("backend.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=add&name=" + encodeURIComponent(name)
      }).then(() => {
        document.getElementById("taskName").value = "";
        loadTasks();
      });
    });
  
    function startTask(index) {
      fetch("backend.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=start&index=" + index
      }).then(loadTasks);
    }
  
    function stopTask(index) {
      fetch("backend.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=stop&index=" + index
      }).then(loadTasks);
    }
  
    function loadTasks() {
      fetch("backend.php?action=list")
        .then((res) => res.json())
        .then((data) => {
          taskList.innerHTML = "";
          data.forEach((task, i) => {
            const li = document.createElement("li");
            li.textContent = `${task.name} — ${task.totalSeconds}s`;
  
            const startBtn = document.createElement("button");
            startBtn.textContent = "Start";
            startBtn.onclick = () => startTask(i);
  
            const stopBtn = document.createElement("button");
            stopBtn.textContent = "Stop";
            stopBtn.onclick = () => stopTask(i);
  
            li.appendChild(startBtn);
            li.appendChild(stopBtn);
            taskList.appendChild(li);
          });
        });
    }
  
    loadTasks();
  });

