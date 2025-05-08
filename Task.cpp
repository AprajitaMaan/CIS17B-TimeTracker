#include "Task.h"
#include <iostream>

// Constructor that sets task name and initializes values
Task::Task(const std::string& taskName) : name(taskName), running(false), totalSeconds(0) {}

// Start timing the task
void Task::start() {
    if (!running) {
        running = true;
        startTime = std::chrono::system_clock::now();
    }
}

// Stop timing and update total time
void Task::stop() {
    if (running) {
        auto endTime = std::chrono::system_clock::now();
        totalSeconds += std::chrono::duration_cast<std::chrono::seconds>(endTime - startTime).count();
        running = false;
    }
}

// Return total time tracked
int Task::getTotalSeconds() const {
    return totalSeconds;
}

// Get task name
std::string Task::getName() const {
    return name;
}

// Check if task is currently running
bool Task::isRunning() const {
    return running;
}

// Write task data to binary file
void Task::saveToBinary(std::ofstream& out) const {
    size_t len = name.length();
    out.write(reinterpret_cast<const char*>(&len), sizeof(len));
    out.write(name.c_str(), len);
    out.write(reinterpret_cast<const char*>(&totalSeconds), sizeof(totalSeconds));
}

// Load task data from binary file
void Task::loadFromBinary(std::ifstream& in) {
    size_t len;
    in.read(reinterpret_cast<char*>(&len), sizeof(len));
    name.resize(len);
    in.read(&name[0], len);
    in.read(reinterpret_cast<char*>(&totalSeconds), sizeof(totalSeconds));
    running = false;
}
