#include "Task.h"
#include <iostream>

Task::Task(const std::string& taskName) : name(taskName), running(false), totalSeconds(0) {}

void Task::start() {
    if (!running) {
        running = true;
        startTime = std::chrono::system_clock::now();
    }
}

void Task::stop() {
    if (running) {
        auto endTime = std::chrono::system_clock::now();
        totalSeconds += std::chrono::duration_cast<std::chrono::seconds>(endTime - startTime).count();
        running = false;
    }
}

int Task::getTotalSeconds() const {
    return totalSeconds;
}

std::string Task::getName() const {
    return name;
}

bool Task::isRunning() const {
    return running;
}