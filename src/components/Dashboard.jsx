import React from 'react';
import { BASE_URL } from '../util/constants';
import {
  Button,
  ButtonGroup,
  Container,
  Form,
  ListGroup
} from 'react-bootstrap';

export default class Dashboard extends React.Component {
  render() {
    let defineCell = (index, cell) => {
      let className;

      switch (index) {
        case 1:
          className = 'col-md-2';
          break;

        default:
          className = 'col';
      }
      return <ListGroup.Item className={className}>{cell}</ListGroup.Item>;
    };
    let defineCells = (index, cells) => {
      let result = cells
        .slice(1, 3)
        .map((cell, index) => defineCell(index, cell));
      let action = '';

      return (
        <>
          <ListGroup.Item className="col-1">{index}</ListGroup.Item>
          {result}
          <ListGroup.Item className="col">
            <Form
              onSubmit={(e) => {
                e.target.action = action;
              }}
              method="GET"
            >
              <ButtonGroup aria-label="Actions">
                <Button
                  type="submit"
                  onClick={() => {
                    action = `/project/view/${cells[0]}`;
                  }}
                  variant="primary"
                >
                  View
                </Button>
                <Button
                  type="submit"
                  onClick={() => {
                    action = `/project/edit/${cells[0]}`;
                  }}
                  variant="warning"
                >
                  Edit
                </Button>
                <Button
                  type="submit"
                  onClick={() => {
                    action = `/project/delete/${cells[0]}`;
                  }}
                  variant="danger"
                >
                  Delete
                </Button>
              </ButtonGroup>
            </Form>
          </ListGroup.Item>
        </>
      );
    };
    let defineRow = (index, row) => {
      let result = defineCells(index, row.split(','));

      return <ListGroup horizontal>{result}</ListGroup>;
    };
    let defineRows = (rows) => {
      let result =
        rows !== ''
          ? rows.split('|').map((row, index) => defineRow(index, row))
          : '';

      return result;
    };
    /**
     * @description Items format is like this: ROW_ID,PROJECT_TITLE,PROJECT_DATE|ROW_ID,PROJECT_TITLE,PROJECT_DATE|...
     */
    let rows = this.props.items ?? '';

    return (
      <Container className="my-3 justify-content-center">
        <ListGroup key="0" horizontal>
          <ListGroup.Item className="col-1">#</ListGroup.Item>
          <ListGroup.Item className="col">Project Title</ListGroup.Item>
          <ListGroup.Item className="col-2">Project Date</ListGroup.Item>
          <ListGroup.Item className="col">Actions</ListGroup.Item>
        </ListGroup>
        {defineRows(rows)}
      </Container>
    );
  }
}
