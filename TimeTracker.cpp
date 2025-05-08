#include "TimeTracker.h"
#include "Utils.h"
#include <iostream>
#include <fstream>

// Constructor that sets admin flag
TimeTracker::TimeTracker(bool admin) : isAdmin(admin) {}

// Add a new task to the list
void TimeTracker::addTask(const std::string& name) {
    tasks.emplace_back(name);
}

// Start a task by index
void TimeTracker::startTask(int index) {
    if (index >= 0 && index < tasks.size()) {
        tasks[index].start();
        std::cout << "Started task: " << tasks[index].getName() << "\n";
    }
}

// Stop a task by index
void TimeTracker::stopTask(int index) {
    if (index >= 0 && index < tasks.size()) {
        tasks[index].stop();
        std::cout << "Stopped task: " << tasks[index].getName() << "\n";
    }
}

// Show a summary report of all tasks
void TimeTracker::showReport() const {
    std::cout << "\n--- Time Report ---\n";
    for (const auto& task : tasks) {
        std::cout << task.getName() << " - " << formatTime(task.getTotalSeconds());
        if (task.isRunning()) std::cout << " (running)";
        std::cout << "\n";
    }
    std::cout << "-------------------\n";
}

// Show all tasks with their current state
void TimeTracker::showTasks() const {
    for (size_t i = 0; i < tasks.size(); ++i) {
        std::cout << i << ": " << tasks[i].getName();
        if (tasks[i].isRunning()) std::cout << " (running)";
        std::cout << "\n";
    }
}

// Return total number of tasks
int TimeTracker::getTaskCount() const {
    return tasks.size();
}

// Save all tasks to binary file
void TimeTracker::saveToFile(const std::string& filename) const {
    std::ofstream out(filename, std::ios::binary);
    size_t count = tasks.size();
    out.write(reinterpret_cast<const char*>(&count), sizeof(count));
    for (const auto& task : tasks)
        task.saveToBinary(out);
}

// Load tasks from a binary file
void TimeTracker::loadFromFile(const std::string& filename) {
    std::ifstream in(filename, std::ios::binary);
    if (!in) return;
    size_t count;
    in.read(reinterpret_cast<char*>(&count), sizeof(count));
    tasks.resize(count);
    for (auto& task : tasks)
        task.loadFromBinary(in);
}

// Check if user is admin
bool TimeTracker::getIsAdmin() const {
    return isAdmin;
}
