#ifndef TASK_H
#define TASK_H

#include <string>
#include <chrono>

class Task {
private:
    std::string name;
    std::chrono::time_point<std::chrono::system_clock> startTime;
    bool running;
    int totalSeconds;

public:
    Task(const std::string& taskName);
    void start();
    void stop();
    int getTotalSeconds() const;
    std::string getName() const;
    bool isRunning() const;
};

#endif