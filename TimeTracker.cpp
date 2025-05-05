#include "TimeTracker.h"
#include "Utils.h"
#include <iostream>

void TimeTracker::addTask(const std::string& name) {
    tasks.emplace_back(name);
}

void TimeTracker::startTask(int index) {
    if (index >= 0 && index < tasks.size()) {
        tasks[index].start();
        std::cout << "Started task: " << tasks[index].getName() << "\n";
    }
}

void TimeTracker::stopTask(int index) {
    if (index >= 0 && index < tasks.size()) {
        tasks[index].stop();
        std::cout << "Stopped task: " << tasks[index].getName() << "\n";
    }
}

void TimeTracker::showReport() const {
    std::cout << "\n--- Time Report ---\n";
    for (const auto& task : tasks) {
        std::cout << task.getName() << " - " << formatTime(task.getTotalSeconds());
        if (task.isRunning()) std::cout << " (running)";
        std::cout << "\n";
    }
    std::cout << "-------------------\n";
}

void TimeTracker::showTasks() const {
    for (size_t i = 0; i < tasks.size(); ++i) {
        std::cout << i << ": " << tasks[i].getName();
        if (tasks[i].isRunning()) std::cout << " (running)";
        std::cout << "\n";
    }
}

int TimeTracker::getTaskCount() const {
    return tasks.size();
}
