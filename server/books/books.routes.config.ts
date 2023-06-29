import jwtMiddleware from '../auth/middleware/jwt.middleware';
import permissionMiddleware from '../common/middleware/common.permission.middleware';
import { PermissionFlag } from '../common/middleware/common.permissionflag.enum';
import BodyValidationMiddleware from '../common/middleware/body.validation.middleware';
import { body } from 'express-validator';

import express from 'express';
import { CommonRoutesConfig } from '../common/common.routes.config';
import booksController from './controllers/books.controller';
import booksMiddleware from './middleware/books.middleware';

export class BooksRoutes extends CommonRoutesConfig {
    constructor(app: express.Application) {
        super(app, 'BooksRoutes');
    }


    
    configureRoutes(): express.Application {
        this.app
            .route(`/users/:userId/books`)
            .get(
                jwtMiddleware.validJWTNeeded,
                permissionMiddleware.permissionFlagRequired(
                    PermissionFlag.ADMIN_PERMISSION
                ),
                booksController.listBooks
            )
            .post(
                booksMiddleware.validateRequiredBookBodyFields,
                booksController.createBook
            );

            this.app
            .route(`/users/:userId/books/:bookId`)
            .all(
                booksMiddleware.validateBookExists,
                jwtMiddleware.validJWTNeeded,
                booksMiddleware.validateBookExists,
                permissionMiddleware.onlySameUserOrAdminCanDoThisAction
            )
            .get(booksController.getBookById)
            .delete(booksController.removeBook);

            this.app
            .route(`/users/:userId/books/:bookId`)
            .put( 
                booksMiddleware.validateRequiredBookBodyFields,
                BodyValidationMiddleware.verifyBodyFieldsErrors,
                booksMiddleware.validateBookExists,
                permissionMiddleware.permissionFlagRequired(
                    PermissionFlag.PAID_PERMISSION
                ),
                booksController.put,
            );
    
            this.app.patch(`/users/:userId/books/:bookId`, [
                body('permissionFlags').isInt().optional(),
                booksMiddleware.validateRequiredBookBodyFields,
                booksMiddleware.validatePathIdBookNotEmpty,
                BodyValidationMiddleware.verifyBodyFieldsErrors,
                permissionMiddleware.permissionFlagRequired(
                    PermissionFlag.PAID_PERMISSION
                ),
                booksController.patch,
            ]);
    
      ;
      return this.app;
    }
}