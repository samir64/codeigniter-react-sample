import React from 'react';
import { BASE_URL } from '../util/constants';
import { Button, Container, Form, Row } from 'react-bootstrap';

export default class Main extends React.Component {
  render() {
    return (
      <Container>
        <Form
          action={`/project/save/${this.props.project_id}`}
          method="POST"
          className="form mx-auto"
          encType="multipart/form-data"
        >
          <Form.Group controlId="projectTitle">
            <Form.Label>Project Title</Form.Label>
            <Form.Control placeholder="Project Title" name="title" defaultValue={this.props.project_title} />
            <Form.Text className="text-muted"></Form.Text>
          </Form.Group>

          <Form.Group controlId="projectDescription">
            <Form.Label>Project Description</Form.Label>
            <Form.Control
              placeholder="Project Description"
              name="description"
              defaultValue={this.props.project_description}
            />
            <Form.Text className="text-muted"></Form.Text>
          </Form.Group>

          <Form.Group controlId="file">
            <Form.Label>Replace Project Data (If you want to use current uploaded file leave it empty):</Form.Label>
            <div></div>
            <Form.Control type="file" placeholder="Project Data" name="file" />
            <Form.Text className="text-muted"></Form.Text>
          </Form.Group>

          <Row>
            <Button
              variant="primary"
              className="col-12 col-md-2"
              block
              type="submit"
            >
              Save
            </Button>
          </Row>
        </Form>
      </Container>
    );
  }
}
