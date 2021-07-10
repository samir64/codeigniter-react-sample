import React from 'react';
import { BASE_URL } from '../util/constants';
import { Button, Container, Form, Row } from 'react-bootstrap';

export default class Main extends React.Component {
  render() {
    return (
      <Container>
        <Form
          action={`/project/delete_confirm/${this.props.project_id}`}
          method="POST"
          className="form mx-auto"
        >
          <Form.Group controlId="projectTitle">
            <Form.Label>Project Title</Form.Label>
            <Form.Control placeholder="Project Title" name="title" defaultValue={this.props.project_title} disabled />
            <Form.Text className="text-muted"></Form.Text>
          </Form.Group>

          <Form.Group controlId="projectDescription">
            <Form.Label>Project Description</Form.Label>
            <Form.Control
              placeholder="Project Description"
              name="description"
              defaultValue={this.props.project_description}
              disabled
            />
            <Form.Text className="text-muted"></Form.Text>
          </Form.Group>

          <Form.Group controlId="file">
            <Form.Label>Do you realy want to delete this project?</Form.Label>
          </Form.Group>

          <Row>
            <Button
              variant="danger"
              className="col-12 col-md-2 me-md-2"
              block
              type="submit"
            >
              Yes
            </Button>
            <Button
              variant="info"
              className="col-12 col-md-2 ms-md-2"
              block
              onClick={() => {window.location.href="/dashboard"}}
            >
              No
            </Button>
          </Row>
        </Form>
      </Container>
    );
  }
}
