// src/lib/api.js
const API_BASE = "http://localhost/taskflow-lite/api";

export async function getProjects() {
  const res = await fetch(`${API_BASE}/projects.php`);
  return res.json();
}

export async function createProject(name, description) {
  const res = await fetch(`${API_BASE}/projects.php`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ name, description }),
  });

  return res.json();
}
