import { useState } from "react";
import { createProject } from "../lib/api.js";

export default function CreateProjectForm() {
  const [name, setName] = useState("");
  const [desc, setDesc] = useState("");
  const [msg, setMsg] = useState("");

  async function submit(e) {
    e.preventDefault();
    const res = await createProject(name, desc);

    if (res.success) {
      setMsg("Proyecto creado ✔");
      setName("");
      setDesc("");
    } else {
      setMsg("Error creando proyecto");
    }
  }

  return (
    <>
      <form onSubmit={submit} className="project-form">
        <input
          required
          placeholder="Nombre del proyecto"
          value={name}
          onInput={(e) => setName(e.target.value)}
        />

        <textarea
          placeholder="Descripción"
          value={desc}
          onInput={(e) => setDesc(e.target.value)}
        />

        <button className="btn-primary">Crear proyecto</button>
      </form>

      {msg && <p className="status-msg">{msg}</p>}
    </>
  );
}
