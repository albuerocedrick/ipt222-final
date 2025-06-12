-- USERS TABLE
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    f_name VARCHAR(50) NOT NULL,
    l_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_pic VARCHAR(255), -- File path or URL
    is_admin BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- PROJECTS TABLE
CREATE TABLE projects (
    project_id INT PRIMARY KEY AUTO_INCREMENT,
    owner_id INT NOT NULL,
    project_name VARCHAR(100),
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES users(user_id)
);

-- TASKS TABLE
CREATE TABLE tasks (
    task_id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT NOT NULL,
    title VARCHAR(100),
    description TEXT,
    status ENUM(
        'Not Started',
        'In Progress',
        'Near Deadline',
        'Done',
        'Submitted Late',
        'Missed'
    ) DEFAULT 'Not Started',
    start_date DATE,
    due_date DATE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(project_id)
);

-- COLLABORATORS TABLE
CREATE TABLE collaborators (
    project_id INT,
    user_id INT,
    permission_level ENUM('admin', 'read_only') DEFAULT 'read_only',
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    added_by INT,
    added_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (project_id, user_id),
    FOREIGN KEY (project_id) REFERENCES projects(project_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (added_by) REFERENCES users(user_id)
);

-- TASK SUBMISSIONS TABLE
CREATE TABLE task_submissions (
    submission_id INT PRIMARY KEY AUTO_INCREMENT,
    task_id INT NOT NULL,
    submitted_by INT NOT NULL,
    photo_url VARCHAR(255) NOT NULL,
    submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES tasks(task_id),
    FOREIGN KEY (submitted_by) REFERENCES users(user_id)
);

-- ACCESS REQUESTS TABLE
CREATE TABLE access_requests (
    request_id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT NOT NULL,
    requester_id INT NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    requested_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    reviewed_at DATETIME,
    reviewed_by INT,
    FOREIGN KEY (project_id) REFERENCES projects(project_id),
    FOREIGN KEY (requester_id) REFERENCES users(user_id),
    FOREIGN KEY (reviewed_by) REFERENCES users(user_id)
);

-- NOTIFICATIONS TABLE
CREATE TABLE notifications (
    notification_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);