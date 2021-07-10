import React from 'react';
import { BASE_URL } from '../util/constants';
import { Button, ButtonGroup, Form, Jumbotron, Text } from 'react-bootstrap';

export default class ViewProject extends React.Component {
  left = 0;
  processIndex = -1;
  status = 'PAUSE';
  lastTime = 0;
  step = 100;
  rows = [];

  animate() {
    let now = Date.now() / 1000;
    if (this.lastTime === 0) {
      this.lastTime = now;
    }

    this.left += (1000 / this.step) * (now - this.lastTime);

    while (
      this.processIndex < this.rows.length &&
      (this.processIndex < 0 || this.rows[this.processIndex][7] < this.left)
    ) {
      this.processIndex++;
      if (this.processIndex < this.rows.length) {
        document.getElementById(`process${this.processIndex}`).style.display =
          'block';
      }
    }
    if (this.processIndex >= this.rows.length) {
      this.processIndex = this.rows.length;
      this.pause();
    }

    this.lastTime = now;

    if (this.status === 'PLAY') {
      requestAnimationFrame(this.animate.bind(this));
    }
  }

  start() {
    this.status = 'PLAY';
    this.animate.bind(this)();
  }

  stop() {
    for (let i = 0; i < this.rows.length; i++) {
      document.getElementById(`process${i}`).style.display = 'none';
    }
    this.left = 0;
    this.lastTime = 0;
    this.processIndex = -1;
    this.status = 'STOP';
  }

  pause() {
    this.lastTime = 0;
    this.status = 'PAUSE';
  }

  render() {
    let columns = [
      'Process',
      'Workstation',
      'Line',
      'Process number',
      'Sum Time',
      'Time, value adding',
      'Time, non value adding'
    ];
    let left = 0;
    this.rows = globalData.table
      .filter((row) => row.Process.toLowerCase() !== 'all')
      // .slice(0, 20)
      .map((row) => {
        let result = [...columns.map((column) => row[column]), left];

        left += Math.round(row['Sum Time']);
        return result;
      });
    let totalTime = this.rows.reduce(
      (result, current) => result + Math.round(current[4]),
      0
    );

    return (
      <Jumbotron>
        <Form.Group className="form-control">
          <Form.Label>Animation Panel</Form.Label>
          <div></div>
          <div
            style={{
              display: 'flex',
              alignItems: 'flex-end'
            }}
            className="form-control-item"
          >
            <ButtonGroup className="form-control-item" aria-label="Actions">
              <Button variant="success" onClick={this.start.bind(this)}>
                Play
              </Button>
              <Button variant="warning" onClick={this.pause.bind(this)}>
                Pause
              </Button>
              <Button variant="danger" onClick={this.stop.bind(this)}>
                Stop
              </Button>
            </ButtonGroup>
            <div
              style={{ display: 'flex', flexDirection: 'column' }}
              className="form-control-item"
            >
              <Form.Label>Step (milliseconds)</Form.Label>
              <Form.Control
                id="step"
                type="number"
                placeholder={this.step}
                defaultValue={this.step}
              />
              <Form.Text className="text-muted"></Form.Text>
            </div>
            <Button
              variant="success"
              className="form-control-item"
              onClick={() => {
                this.step = parseInt(
                  document.getElementById('step').value ?? 100
                );
              }}
            >
              Apply
            </Button>
          </div>
        </Form.Group>

        <div
          id="timeline"
          className="form-control-item timeline"
          style={{ width: `${totalTime * 10}px` }}
        >
          {this.rows.map((row, index) => (
            <div key={index} id={`process${index}`} style={{ display: 'none' }}>
              <div
                className="timeline-line"
                style={{
                  left: `${(100 * row[7]) / totalTime}%`,
                  width: `${(100 * Math.round(row[4])) / totalTime}%`
                }}
              >
                <div
                  className="timeline-process-title"
                  style={{
                    left: `${
                      (100 * (row[7] + Math.round(row[4]) / 2)) / totalTime
                    }%`
                  }}
                >
                  {row[0]}
                </div>
                <div
                  className="timeline-process"
                  style={{
                    left: `${
                      (100 * (row[7] + Math.round(row[4]) / 2)) / totalTime
                    }%`
                  }}
                ></div>
              </div>
            </div>
          ))}
        </div>
      </Jumbotron>
    );
  }
}
