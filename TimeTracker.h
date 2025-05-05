#ifndef TIMETRACKER_H
#define TIMETRACKER_H

#include <vector>
#include "Task.h"

class TimeTracker {
private:
    std::vector<Task> tasks;

public:
    void addTask(const std::string& name);
    void startTask(int index);
    void stopTask(int index);
    void showReport() const;
    void showTasks() const;
    int getTaskCount() const;
};

#endif