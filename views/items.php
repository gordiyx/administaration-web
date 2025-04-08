<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>React Buttons</title>
  <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
</head>
<body>

  <h1>React Buttons</h1>

  <div id="root"></div>

  <script type="text/babel">
    function Panel({ buttons, shadow }) {
      const panelStyle = {
        display: 'inline-flex',
        gap: '0px',
        flexWrap: 'nowrap',
        backgroundColor: 'transparent', 
        padding: '10px',
      };

      return (
        <div style={panelStyle}>
          {buttons.map((button, index) => {
            const buttonStyle = {
              padding: '8px 16px',
              backgroundColor: button.color,
              border: 'none',
              borderTopLeftRadius: index === 0 ? '15px' : '0',
              borderBottomLeftRadius: index === 0 ? '15px' : '0',
              borderTopRightRadius: index === buttons.length - 1 ? '15px' : '0',
              borderBottomRightRadius: index === buttons.length - 1 ? '15px' : '0',
              color: button.inverse ? '#fff' : '#000',
              fontWeight: 'bold',
              cursor: 'pointer',
              boxShadow: shadow ? '0 6px 12px rgba(0, 0, 0, 0.2)' : 'none',
              transition: 'box-shadow 0.2s ease',
            };

            return (
              <button
                key={index}
                style={buttonStyle}
                //onMouseOver={(e) => e.target.style.boxShadow = '0 6px 12px rgba(0, 0, 0, 0.2)'}
                //onMouseOut={(e) => e.target.style.boxShadow = shadow ? '0 4px 8px rgba(0, 0, 0, 0.15)' : 'none'} 
              >
                {button.text}
              </button>
            );
          })}
        </div>
      );
    }

    const buttons1 = [
      { text: "add", color: "#eeeeee" },
      { text: "edit", color: "#eeeeee" },
      { text: "delete", color: "#FF5733", inverse: true }
    ];

    const buttons2 = [
      { text: "a", color: "#34eb8f" },
      { text: "b", color: "#1f8753", inverse: true },
      { text: "c", color: "#34eb8f" },
      { text: "d", color: "#1f8753", inverse: true },
      { text: "e", color: "#34eb8f" }
    ];

    const buttons3 = [
      { text: "info", color: "#349beb", inverse: true },
    ];

    const root = ReactDOM.createRoot(document.getElementById('root'));
    root.render(
      <>
        <Panel shadow buttons={buttons1} /> 
        <Panel buttons={buttons1} />
        <Panel buttons={buttons2} />
        <Panel buttons={buttons3} />
        <Panel shadow buttons={buttons3} /> 
      </>
    );
  </script>
</body>
</html>
