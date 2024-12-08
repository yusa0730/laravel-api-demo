# メンタリング用に利用するlaravelで作成したTodoリストのCRUD処理を行えるAPIサーバー

## 開発環境
- Laravelバージョン10
- Swagger OpenAPI
  - メンタリング用のためyamlファイルで記載。後々OpenAPI generatorを利用したコード化に修正予定

## APIの利用の仕方

- ユーザー新規登録(emailが重複している場合は別のemailを利用する)

  - リクエスト
```
curl -X POST https://www.gaku-portfolio.com/api/v1/auth/register \
-H "Content-Type: application/json" \
-d '{
  "name": "Taro",
  "email": "test@gmail.com",
  "password": "test123",
  "confirmPassword": "test123"
}'
```

  - レスポンス
```
{"status":201,"data":{"accessToken":"7|HJEvYix5NmN1XRqbKzohU5nQ7kzMLYOdCppQPcQt29f9443f","userId":5},"message":"User Registeration successfully"}
```

- ログイン
  - リクエスト
```
curl -X POST https://www.gaku-portfolio.com/api/v1/auth/logout \
-H "Content-Type: application/json" \
-H "Authorization: Bearer [Access token]"
```

  - レスポンス
```
{"status":200,"data":{"token":"8|ctx1We4o5H2dlhyccflXBqU3xOYdWDeyebjomZTPfd39438c","userId":5},"message":"User Login Successfully"}%
```

- ログアウト

  - リクエスト
```
curl -X POST https://www.gaku-portfolio.com/api/v1/auth/logout \
-H "Content-Type: application/json" \
-H "Authorization: Bearer [Access token]"
```

  - レスポンス
```
{"status":200,"message":"successfully logout"}%
```

- ユーザー取得

  - リクエスト
```

```

  - レスポンス
```

```

- todo一覧取得

  - リクエスト
```

```

  - レスポンス
```

```

- todo詳細取得

  - リクエスト
```

```

  - レスポンス
```

```

- todo新規作成

  - リクエスト
```

```

  - レスポンス
```

```

- todo更新

  - リクエスト
```

```

  - レスポンス
```

```


- todo削除

  - リクエスト
```

```

  - レスポンス
```

```

