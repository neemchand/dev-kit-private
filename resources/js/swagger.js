import SwaggerUI from 'swagger-ui'
import 'swagger-ui/dist/swagger-ui.css';

SwaggerUI({
    dom_id: '#swagger-api',
    url: 'http://18.12.1.1/openapi/api.yaml',
});
