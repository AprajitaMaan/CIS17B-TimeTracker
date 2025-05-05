#include "TimeTracker.h"
#include <iostream>

void showMenu() {
    std::cout << "\nTime Tracker Menu:\n";
    std::cout << "1. Add Task\n";
    std::cout << "2. Start Task\n";
    std::cout << "3. Stop Task\n";
    std::cout << "4. Show Report\n";
    std::cout << "5. Exit\n";
    std::cout << "Enter your choice: ";
}

int main() {
    TimeTracker tracker;
    int choice;

    while (true) {
        showMenu();
        std::cin >> choice;

        if (choice == 1) {
            std::string name;
            std::cout << "Enter task name: ";
            std::cin.ignore();
            std::getline(std::cin, name);
            tracker.addTask(name);
        } else if (choice == 2) {
            tracker.showTasks();
            int index;
            std::cout << "Enter task number to start: ";
            std::cin >> index;
            tracker.startTask(index);
        } else if (choice == 3) {
            tracker.showTasks();
            int index;
            std::cout << "Enter task number to stop: ";
            std::cin >> index;
            tracker.stopTask(index);
        } else if (choice == 4) {
            tracker.showReport();
        } else if (choice == 5) {
            break;
        } else {
            std::cout << "Invalid choice.\n";
        }
    }

    return 0;
}