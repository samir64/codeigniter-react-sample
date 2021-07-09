import React from 'react';
import { BASE_URL } from '../util/constants';
import { Form, Button, Row, Container } from 'react-bootstrap';

export default class Main extends React.Component {
  render() {
    let values = !!this.props.data ? this.props.data.split(',') : [];
    values = values.reduce(
      (result, value) => ({
        ...result,
        [value.split('=')[0]]: value.split('=')[1]
      }),
      {}
    );

    let errors = this.props.errors ? this.props.errors.split(',') : [];
    let usernameHasError = errors.some((field) => field === 'username');
    let passwordHasError = errors.some((field) => field === 'password');

    return (
      <Container>
        <Form
          className="login-form"
          action={`${BASE_URL}/login/check`}
          method="POST"
        >
          <Form.Group
            controlId="formBasicUsername"
            className={usernameHasError ? 'outline-danger' : ''}
          >
            <Form.Label>Username</Form.Label>
            <Form.Control
              placeholder="Username"
              name="username"
              defaultValue={values.username ?? ''}
            />
            <Form.Text className="text-muted"></Form.Text>
          </Form.Group>

          <Form.Group
            controlId="formBasicPassword"
            className={passwordHasError ? 'outline-danger' : ''}
          >
            <Form.Label>Password</Form.Label>
            <Form.Control
              type="password"
              placeholder="Password"
              name="password"
            />
          </Form.Group>
          <Row>
            <Button
              variant="primary"
              className="col-12 col-md-2"
              block
              type="submit"
            >
              Login
            </Button>
          </Row>
        </Form>
      </Container>
    );
  }
}
