package main

import (
	"context"
	"strings"

	"github.com/gofiber/fiber/v2"
	"github.com/redis/go-redis/v9"
)

var ctx = context.Background()

func main() {
	app := fiber.New()

	// Koneksi ke Redis
	rdb := redis.NewClient(&redis.Options{
		Addr: "redis-cache:6379",
	})

	app.Get("/api/admin/data", func(c *fiber.Ctx) error {
		skor1, _ := rdb.Get(ctx, "skor:paslon1").Int()
		skor2, _ := rdb.Get(ctx, "skor:paslon2").Int()
		skor3, _ := rdb.Get(ctx, "skor:paslon3").Int()

		keys, _ := rdb.Keys(ctx, "voted:*").Result()
		voters := make([]string, 0)
		for _, key := range keys {
			nama := strings.Replace(key, "voted:", "", 1)
			voters = append(voters, strings.ToUpper(nama))
		}

		return c.JSON(fiber.Map{
			"skor1": skor1,
			"skor2": skor2,
			"skor3": skor3,
			"total_voters": len(keys),
			"voters": voters,
		})
	})

	app.Listen(":8080")
}