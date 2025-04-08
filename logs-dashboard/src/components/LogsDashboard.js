import React, { useEffect, useState } from "react";
import axios from "axios";
import "./Logs.css";

const LogsDashboard = () => {
  const [logs, setLogs] = useState([]);
  const [displayCount, setDisplayCount] = useState(10); // Количество выводимых логов
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  // Загрузка логов с сервера
  useEffect(() => {
    axios
      .get("http://localhost/get_logs.php") // URL PHP-скрипта
      .then((response) => {
        setLogs(response.data);
        setLoading(false);
      })
      .catch((err) => {
        console.error("Error loading logs:", err);
        setError("Failed to load logs. Please try again later.");
        setLoading(false);
      });
  }, []);

  // Удаление лога
  const handleDelete = (id) => {
    setLogs(logs.filter((log) => log.id !== id));
  };

  // Фильтрация логов на основе displayCount
  const filteredLogs = logs.slice(-displayCount);

  if (loading) {
    return <div>Loading...</div>;
  }

  if (error) {
    return <div style={{ color: "red" }}>{error}</div>;
  }

  return (
    <div className="container mt-5">
      <h1 className="text-center mb-4">Logs Dashboard</h1>

      {/* Выбор количества логов для отображения */}
      <div className="mb-3">
        <label>
          Show last logs:{" "}
          <input
            type="number"
            value={displayCount}
            min="1"
            max={logs.length}
            onChange={(e) => setDisplayCount(Number(e.target.value))}
          />
        </label>
      </div>

      {/* Таблица логов */}
      <table className="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Office</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {filteredLogs.length > 0 ? (
            filteredLogs.map((log) => (
              <tr key={log.id}>
                <td>{log.id}</td>
                <td>{log.name}</td>
                <td>{log.surname}</td>
                <td>{log.email}</td>
                <td>{log.phone || "N/A"}</td>
                <td>{log.office || "N/A"}</td>
                <td>{log.description || "N/A"}</td>
                <td>
                  <button
                    className="btn btn-danger"
                    onClick={() => handleDelete(log.id)}
                  >
                    Delete
                  </button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="7" className="text-center text-muted">
                No logs to display.
              </td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default LogsDashboard;
