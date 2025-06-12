document.addEventListener('DOMContentLoaded', function() {
    const usersContainer = document.getElementById('users-container');
    const refreshBtn = document.getElementById('refresh-btn');
    const currentUser = usersContainer.dataset.currentUser;

    async function loadUsers() {
        try {
            usersContainer.innerHTML = '<p>Loading users...</p>';
            
            const response = await fetch('/api/admin.php?action=get_all_users');
            if (!response.ok) throw new Error('Failed to fetch users');
            
            const users = await response.json();
            displayUsers(users);
        } catch (error) {
            usersContainer.innerHTML = `
                <div class="error">
                    <p>Error loading users: ${error.message}</p>
                    <button onclick="location.reload()">Try Again</button>
                </div>
            `;
            console.error('Error:', error);
        }
    }

    function displayUsers(users) {
        usersContainer.innerHTML = `
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ${Object.entries(users).map(([username, userData]) => `
                        <tr>
                            <td>
                                ${username}
                                ${username === currentUser ? ' (You)' : ''}
                            </td>
                            <td>
                                ${userData.is_admin ? 
                                    '<span class="admin-badge">Admin</span>' : 
                                    'User'}
                            </td>
                            <td>${new Date(userData.created_at).toLocaleDateString()}</td>
                            <td>
                                ${!userData.is_admin && username !== currentUser ? 
                                    `<button class="delete-btn" data-username="${username}">Delete</button>` : 
                                    '-'}
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;

        // Add delete button handlers
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                if (!confirm(`Delete user ${this.dataset.username}?`)) return;
                
                try {
                    const response = await fetch('/api/admin.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({
                            action: 'delete_user',
                            username: this.dataset.username
                        })
                    });
                    
                    if (!response.ok) throw new Error(await response.text());
                    loadUsers(); // Refresh the list
                } catch (error) {
                    alert('Delete failed: ' + error.message);
                }
            });
        });
    }

    // Initial load
    loadUsers();
    refreshBtn.addEventListener('click', loadUsers);
});