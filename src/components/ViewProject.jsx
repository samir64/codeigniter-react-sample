import React from 'react';
import { BASE_URL } from '../util/constants';
import { Button, Jumbotron, Table } from 'react-bootstrap';

export default class ViewProject extends React.Component {
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
    let rows = globalData.table
      .filter((row) => row.Process.toLowerCase() !== 'all')
      // .slice(0, 10)
      .map((row) => {
        let result = [...columns.map((column) => row[column]), left];

        left += Math.round(row['Sum Time']);
        return result;
      });
    let totalTime = rows.reduce(
      (result, current) => result + Math.round(current[4]),
      0
    );

    return (
      <Jumbotron>
        <Button
          variant="primary"
          onClick={() => {
            window.location.href = `/project/animate/${this.props.project_id}`;
          }}
        >
          Animate
        </Button>
        <Table className="chart-table">
          <thead>
            <tr className="chart-table-row">
              {columns.map((column, index) => (
                <th className="chart-table-cell" key={index}>
                  {column}
                </th>
              ))}
              <th
                className="chart"
                style={{ minWidth: `${totalTime * 5}px` }}
              ></th>
            </tr>
          </thead>
          <tbody>
            {rows.map((row, rowNo) => (
              <tr key={rowNo} className="chart-table-row">
                {row.slice(0, 7).map((cell, cellNo) => (
                  <td
                    key={cellNo}
                    className="chart-table-cell"
                    style={{ fontWeight: 400 }}
                  >
                    {cell}
                  </td>
                ))}
                <td className="chart-table-cell">
                  <div
                    className="table-chart-progress-container"
                    style={{
                      left: `${(100 * row[7]) / totalTime}%`,
                      width: `${(100 * Math.round(row[4])) / totalTime}%`
                    }}
                  >
                    <div
                      className="table-chart-progress-content"
                      style={{ width: '100%' }}
                    ></div>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </Table>
      </Jumbotron>
    );
  }
}
