#ifndef TIMETRACKER_H
#define TIMETRACKER_H

#include <vector>
#include "Task.h"

// Manages a list of tasks and admin/user access
class TimeTracker {
private:
    std::vector<Task> tasks;
    bool isAdmin;

public:
    TimeTracker(bool admin = false);

    // Add a new task
    void addTask(const std::string& name);

    // Start a task by index
    void startTask(int index);

    // Stop a task by index
    void stopTask(int index);

    // Print all task times
    void showReport() const;

    // Print current tasks
    void showTasks() const;

    // Get number of tasks
    int getTaskCount() const;

    // Save tasks to binary file
    void saveToFile(const std::string& filename) const;

    // Load tasks from binary file
    void loadFromFile(const std::string& filename);

    // Check if current user is admin
    bool getIsAdmin() const;
};

#endif
