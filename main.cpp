#include "TimeTracker.h"
#include <iostream>
#include <vector>


// Display menu options based on admin/user mode
void showMenu(bool isAdmin);

// Main program entry point
int main() {
    char adminChar;
    std::cout << "Are you an admin? (y/n): ";
    std::cin >> adminChar;
    bool isAdmin = (adminChar == 'y' || adminChar == 'Y');
    TimeTracker tracker(isAdmin);

    int choice;
    while (true) {
        showMenu(isAdmin);
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
        } else if (isAdmin && choice == 5) {
            tracker.saveToFile("tasks.dat");
        } else if (isAdmin && choice == 6) {
            tracker.loadFromFile("tasks.dat");
        } else if ((isAdmin && choice == 7) || (!isAdmin && choice == 5)) {
            break;
        } else {
            std::cout << "Invalid choice.\n";
        }
    }

    return 0;
}

// Show menu to user or admin
void showMenu(bool isAdmin) {
    std::cout << "\nTime Tracker Menu:\n";
    std::cout << "1. Add Task\n";
    std::cout << "2. Start Task\n";
    std::cout << "3. Stop Task\n";
    std::cout << "4. Show Report\n";
    if (isAdmin) {
        std::cout << "5. Save Tasks\n";
        std::cout << "6. Load Tasks\n";
        std::cout << "7. Exit\n";
    } else {
        std::cout << "5. Exit\n";
    }
    std::cout << "Enter your choice: ";
}
