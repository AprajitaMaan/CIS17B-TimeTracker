#ifndef TASK_H
#define TASK_H

#include <string>
#include <chrono>
#include <fstream>

// Represents a task with a name and time tracking
class Task {
private:
    std::string name;
    std::chrono::time_point<std::chrono::system_clock> startTime;
    bool running;
    int totalSeconds;

public:
    Task(const std::string& taskName = "");

    // Start the timer for the task
    void start();

    // Stop the timer and update total time
    void stop();

    // Return total tracked time in seconds
    int getTotalSeconds() const;

    // Get the name of the task
    std::string getName() const;

    // Check if the task is currently running
    bool isRunning() const;

    // Save task data to binary file
    void saveToBinary(std::ofstream& out) const;

    // Load task data from binary file
    void loadFromBinary(std::ifstream& in);
};

#endif
