import React, { useEffect, useState } from "react";
import { getProjects } from "../lib/api.js";

export default function ProjectListIsland() {
  const [projects, setProjects] = useState([]);
  const [loading, setLoading] = useState(true);

  async function load() {
    const data = await getProjects();
    setProjects(data);
    setLoading(false);
  }

  useEffect(() => {
    load();
  }, []);

  if (loading) return <p>Cargando proyectos...</p>;

  if (!projects.length) return <p>No hay proyectos todavía.</p>;

  return (
    <div className="projects-grid">
      {projects.map((p) => (
        <a className="project-card" key={p.id} href={`/project?id=${p.id}`}>
          <h3>{p.name}</h3>
          <p>{p.description}</p>
        </a>
      ))}
    </div>
  );
}
